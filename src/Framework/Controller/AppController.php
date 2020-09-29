<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\Deploy\DeployApplication;
use App\AppCore\Application\GetMicroServiceApplication;
use App\AppCore\Application\Save\SaveTestApplication;
use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\Status\GetStatus;
use App\AppCore\Domain\Service\Test\Trigger;
use App\Framework\Application\Monitor\Hub;
use App\Framework\Application\Save\FrameworkSaveApplication;
use App\Framework\Entity\Status;
use App\Framework\Service\Files\Dir;
use App\Framework\Service\Files\UploadedFileAdapter;
use App\Framework\Service\MakeConnection;
use App\Framework\Service\Monitor\WebSockets\Context\WrappedContext;
use App\Framework\Subscriber\Event\AfterSavingService;
use App\Framework\Subscriber\Event\SaveStatusEvent;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function array_map;
use function json_decode;
use function uniqid;

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

    /** @var EntityFactoryInterface  */
    private $entityFactory;

    /** @var SaveTestApplication */
    private $application;

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
     * @param EntityFactoryInterface      $entityFactory
     * @param SaveTestApplication         $saveTestApplication
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
        EntityFactoryInterface $entityFactory,
        SaveTestApplication $saveTestApplication
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
        $this->application = $saveTestApplication;
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
    public function test(string $uuid, Request $request)
    {
        //./client.php 'http://service-test-lab-new.local/endpoint' 'Hej udało się 3425345!' 'Bars'
        $uuid2 = uniqid();
        $this->trigger->runRequest(
            $this->findDockerFileDir($uuid),
            self::IMAGE_PREFIX . $uuid2,
            self::CONTAINER_PREFIX . $uuid2,
            json_decode($request->getContent(), true)
        );

        return new Response($this->hub->compare($uuid));
    }

    /**
     * @Route("/save-test/{uuid}", name="saveTest")
     *
     * @param TestDTO $testDTO
     *
     * @return JsonResponse
     */
    public function saveTest(TestDTO $testDTO)
    {
        $this->application->save($testDTO);
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
     * @throws \Exception
     */
    public function endpoint(Request $request)
    {
        $entity = new \App\Framework\Entity\Request();
        $entity->setContent($request->getContent());
        $entity->setHeader($request->headers->get('X-Foo'));

        $this->getDoctrine()->getManager()->persist($entity);
        $this->getDoctrine()->getManager()->flush();

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
        $uniqid = uniqid();

        $this->saveApplication->save(
            new UploadedFileAdapter($request->files->all()['files']),
            $this->dir->sureTargetDirExists($this->getParameter('uploaded_directory') . '/' . $uniqid),
            new DateTime()
        );
        $this->eventDispatcher->dispatch(new AfterSavingService($uniqid), AfterSavingService::NAME);
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
                new DateTime()
            )),
            SaveStatusEvent::NAME
        );
        $this->eventDispatcher->dispatch(new AfterSavingService($uniqid), AfterSavingService::NAME);
        return new Response();
    }

    /**
     * @Route("/get_status", name="get_status")
     * @param Request   $request
     *
     * @param GetStatus $getStatus
     *
     * @return JsonResponse
     */
    public function getStatus(Request $request, GetStatus $getStatus)
    {
        $uniqid = $request->getContent();

        return new JsonResponse(
            array_map(
                function (Status $entity) {
                    return $entity->asArray();
                    },
                $getStatus->getByHash($uniqid)
            )
        );


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
        return $this->dir->findParentDir($this->testRepository->findByHash($uuid)->getUService()->getUnpacked(), 'Dockerfile');
    }
}
