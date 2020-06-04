<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\DeployApplication;
use App\AppCore\Domain\Service\Trigger;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Files\Dir;
use App\Framework\Files\UploadedFileAdapter;
use App\Framework\Persistence\PersistGatewayAdapter;
use App\Framework\Service\MakeConnection;
use App\Framework\Service\WebSockets\Context\WrappedContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AppController
 *
 * @package App\Framework\Controller
 */
class AppController extends AbstractController
{
    const IMAGE_PREFIX = 'image_prefix';
    const CONTAINER_PREFIX = 'container_prefix';
    /**
     * @var FrameworkSaveApplication
     */
    private $saveApplication;
    /**
     * @var DeployApplication
     */
    private $deployApplication;
    /**
     * @var PersistGatewayAdapter
     */
    private $gatewayAdapter;
    /**
     * @var Dir
     */
    private $dir;
    /**
     * @var Trigger
     */
    private $trigger;
    /**
     * @var MakeConnection
     */
    private $makeConnection;

    /**
     * @var WrappedContext $context
     */
    private $context;

    /**
     * AppController constructor.
     *
     * @param FrameworkSaveApplication $saveApplication
     * @param DeployApplication        $deployApplication
     * @param PersistGatewayAdapter    $gatewayAdapter
     * @param Trigger                  $trigger
     * @param Dir                      $dir
     * @param MakeConnection           $makeConnection
     * @param WrappedContext           $context
     */
    public function __construct(
        FrameworkSaveApplication $saveApplication,
        DeployApplication $deployApplication,
        PersistGatewayAdapter $gatewayAdapter,
        Trigger $trigger,
        Dir $dir,
        MakeConnection $makeConnection,
        WrappedContext $context
    ) {
        $this->saveApplication = $saveApplication;
        $this->deployApplication = $deployApplication;
        $this->gatewayAdapter = $gatewayAdapter;
        $this->dir = $dir;
        $this->trigger = $trigger;
        $this->makeConnection = $makeConnection;
        $this->context = $context;
    }

    /**
     * @Route("/", name="app")
     * @return RedirectResponseAlias|Response
     */
    public function index()
    {
        return $this->render('app/index.html.twig');
    }

    /**
     * @Route("/test/{uuid}", name="test")
     * @param string  $uuid
     * @param Request $request
     *
     * @return Response
     */
    public function test(string $uuid, Request $request)
    {
        $this->trigger->runRequest(
            $this->findDockerFileDir($uuid),
            self::IMAGE_PREFIX . '_test',
            self::CONTAINER_PREFIX . '_test',
            \json_decode($request->getContent(), true)
        );
        return new Response();
    }

    /**
     * @Route("/connect/{uuid1}/{uuid2}", name="connect")
     * @param string $uuid1
     * @param string $uuid2
     *
     * @return Response
     */
    public function connect(string $uuid1, string $uuid2)
    {
        $this->makeConnection->make($uuid1, $uuid2);
        return new Response();
    }

    /**
     * @Route("/endpoint", name="endpoint")
     * @param Request $request
     *
     * @return Response
     * @throws \ZMQSocketException
     */
    public function endpoint(Request $request)
    {
        $this->context
            ->send(
                [
                    'request' => $request->getContent(),
                    'headers' => $request->headers->get('X-Foo')
                ]
        );
        return new Response();
    }

    /**
     * @Route("/upload", name="photos.upload")
     * @param Request $request
     *
     * @return Response
     */
    public function upload(Request $request)
    {
        $uniqid = \uniqid();

        $this->saveApplication->save(new UploadedFileAdapter($request->files->all()['files']),
            $this->dir->sureTargetDirExists($this->getParameter('uploaded_directory') . '/' . $uniqid));
        return new Response($uniqid);
    }

    /**
     * @Route("/deploy", name="deploy")
     * @param Request $request
     *
     * @return Response
     */
    public function deploy(Request $request)
    {
        $uniqid = $request->getContent();

        $this->deployApplication->deploy((string)($this->gatewayAdapter->findByHash($uniqid)->getId()),
            $this->dir->sureTargetDirExists($this->getParameter('unpacked_directory') . '/' . $uniqid),
            self::IMAGE_PREFIX,
            self::CONTAINER_PREFIX);
        return new Response();
    }

    /**
     * @Route("/c3/report/{suffix}", name="c3")
     * @return Response
     */
    public function c3(string $suffix)
    {
        return new Response();
    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    private function findDockerFileDir(string $uuid): string
    {
        return $this->dir->findParentDir($this->gatewayAdapter->findByHash($uuid)->getUnpacked(), 'Dockerfile');
    }
}
