<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\DeployApplication;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Files\Dir;
use App\Framework\Files\UploadedFileAdapter;
use App\Framework\Persistence\PersistGatewayAdapter;
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
     * AppController constructor.
     *
     * @param FrameworkSaveApplication $saveApplication
     * @param DeployApplication        $deployApplication
     * @param PersistGatewayAdapter    $gatewayAdapter
     * @param Dir                      $dir
     */
    public function __construct(
        FrameworkSaveApplication $saveApplication,
        DeployApplication $deployApplication,
        PersistGatewayAdapter $gatewayAdapter,
        Dir $dir
    ) {
        $this->saveApplication = $saveApplication;
        $this->deployApplication = $deployApplication;
        $this->gatewayAdapter = $gatewayAdapter;
        $this->dir = $dir;
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
            $this->dir->sureTargetDirExists($this->getParameter('unpacked_directory') . '/' . $uniqid), 'image_prefix',
            'container_prefix');
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
}
