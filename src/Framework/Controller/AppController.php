<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\DeployApplication;
use App\AppCore\Application\GetMicroServiceApplication;
use App\AppCore\Application\Save\SaveTestApplication;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\Trigger;
use App\AppCore\Hub;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Entity\Status;
use App\Framework\Factory\EntityFactory;
use App\Framework\Files\Dir;
use App\Framework\Files\UploadedFileAdapter;
use App\Framework\Repository\TestRepository;
use App\Framework\Repository\UServiceRepository;
use App\Framework\Service\MakeConnection;
use App\Framework\Service\WebSockets\Context\WrappedContext;
use App\Framework\Subscriber\Event\SaveStatusEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @var TestRepositoryInterface
     */
    private $testRepository;
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
     * @var Hub $hub
     */
    private $hub;
    /**
     * @var uServiceRepositoryInterface
     */
    private $serviceRepository;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;
    private $entityFactory;

    /**
     * AppController constructor.
     *
     * @param FrameworkSaveApplication    $saveApplication
     * @param DeployApplication           $deployApplication
     * @param TestRepositoryInterface     $testRepository
     * @param uServiceRepositoryInterface $serviceRepository
     * @param Trigger                     $trigger
     * @param Dir                         $dir
     * @param MakeConnection              $makeConnection
     * @param WrappedContext              $context
     * @param Hub                         $hub
     * @param EventDispatcherInterface    $eventDispatcher
     * @param EntityFactory               $entityFactory
     */
    public function __construct(
        FrameworkSaveApplication $saveApplication,
        DeployApplication $deployApplication,
        TestRepositoryInterface $testRepository,
        uServiceRepositoryInterface $serviceRepository,
        Trigger $trigger,
        Dir $dir,
        MakeConnection $makeConnection,
        WrappedContext $context,
        Hub $hub,
        EventDispatcherInterface $eventDispatcher,
        EntityFactory $entityFactory
    ) {
        $this->saveApplication = $saveApplication;
        $this->deployApplication = $deployApplication;
        $this->testRepository = $testRepository;
        $this->dir = $dir;
        $this->trigger = $trigger;
        $this->makeConnection = $makeConnection;
        $this->context = $context;
        $this->hub = $hub;
        $this->serviceRepository = $serviceRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->entityFactory = $entityFactory;
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
     * @Route("/get-grid-content", name="get_grid_content")
     * @param GetMicroServiceApplication $application
     *
     * @return JsonResponse
     */
    public function getGridContent(GetMicroServiceApplication  $application)
    {
        return new JsonResponse($application->getAllAsArray());
    }


    /**
     * @Route("/test/{uuid}", name="test")
     * @param string  $uuid
     * @param Request $request
     *
     * @return Response
     */
    public function test(string $uuid, Request $request, Hub $hub)
    {
        //./client.php 'http://service-test-lab-new.local/endpoint' 'Hej udało się 3425345!' 'Bars'
        $uuid2 = \uniqid();
        $this->trigger->runRequest(
            $this->findDockerFileDir($uuid),
            self::IMAGE_PREFIX . $uuid2,
            self::CONTAINER_PREFIX . $uuid2,
            \json_decode($request->getContent(), true)
        );

        return new Response($hub->compare($uuid));
    }

    /**
     * @Route("/save-test/{uuid}", name="saveTest")
     * @param Request             $request
     * @param SaveTestApplication $application
     *
     * @param UServiceRepository  $UServiceRepository
     * @param TestRepository      $testRepository
     *
     * @return JsonResponse
     */
    public function saveTest(Request $request, SaveTestApplication  $application, UServiceRepository $UServiceRepository, TestRepository $testRepository, EntityManagerInterface $entityManager)
    {
        $application->save(\json_decode($request->getContent(), true));
        $UServiceRepository->findOneBy(['uuid' => \json_decode($request->getContent(), true)['uuid']])->addTest(
            $testRepository->findOneBy(['uuid' => \json_decode($request->getContent(), true)['uuid']])
        );
        $entityManager->flush();
        return new JsonResponse([]);
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
     */
    public function endpoint(Request $request, Hub $hub)
    {
        $hub->receive($request->getContent(), $request->headers->get('X-Foo'));
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

        $this->deployApplication->deploy((string)($this->serviceRepository->findOneBy(['uuid' => $uniqid])->getId()),
            $this->dir->sureTargetDirExists($this->getParameter('unpacked_directory') . '/' . $uniqid),
            self::IMAGE_PREFIX,
            self::CONTAINER_PREFIX);
        $this->eventDispatcher->dispatch(
            new SaveStatusEvent($this->entityFactory->createStatusEntity(
                $uniqid,
                'service_deployed',
                new \DateTime()
            )),
            SaveStatusEvent::NAME
        );
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
        return $this->dir->findParentDir($this->testRepository->findByHash($uuid)->getUnpacked(), 'Dockerfile');
    }
}
