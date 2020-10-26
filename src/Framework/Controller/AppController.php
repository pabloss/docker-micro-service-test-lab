<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\Deploy\DeployApplication;
use App\AppCore\Application\Save\SaveTestApplication;
use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Actors\Factory\TestDTOFactoryInterface;
use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\Status\GetStatus;
use App\AppCore\Domain\Service\Test\Trigger;
use App\Framework\Application\Get\GetMicroServiceApplication;
use App\Framework\Application\Monitor\Hub;
use App\Framework\Application\Save\FrameworkSaveApplication;
use App\Framework\Entity\Status;
use App\Framework\Service\Files\Dir;
use App\Framework\Service\Files\UploadedFileAdapter;
use App\Framework\Service\Test\Connection;
use App\Framework\Service\Test\Docker;
use App\Framework\Subscriber\Event\AfterSavingService;
use App\Framework\Subscriber\Event\AfterSavingTestEvent;
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
use function uniqid;

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
    private $saveTestApplication;
    /**
     * @var TestDTOFactoryInterface
     */
    private $testDTOFactory;
    /**
     * @var Docker
     */
    private $docker;
    /**
     * @var Connection
     */
    private $connection;

    /**
     * AppController constructor.
     *
     * @param FrameworkSaveApplication    $saveApplication
     * @param DeployApplication           $deployApplication
     * @param TestRepositoryInterface     $testRepository
     * @param uServiceRepositoryInterface $serviceRepository
     * @param Trigger                     $trigger
     * @param Dir                         $dir
     * @param Hub                         $hub
     * @param EventDispatcherInterface    $eventDispatcher
     * @param EntityFactoryInterface      $entityFactory
     * @param SaveTestApplication         $saveTestApplication
     * @param TestDTOFactoryInterface     $testDTOFactory
     * @param Docker                      $docker
     * @param Connection                  $connection
     */
    public function __construct(
        FrameworkSaveApplication $saveApplication,
        DeployApplication $deployApplication,
        TestRepositoryInterface $testRepository,
        uServiceRepositoryInterface $serviceRepository,
        Trigger $trigger,
        Dir $dir,
        Hub $hub,
        EventDispatcherInterface $eventDispatcher,
        EntityFactoryInterface $entityFactory,
        SaveTestApplication $saveTestApplication,
        TestDTOFactoryInterface $testDTOFactory,
        Docker $docker,
        Connection $connection
    ) {
        $this->saveApplication = $saveApplication;
        $this->saveTestApplication = $saveTestApplication;
        $this->deployApplication = $deployApplication;
        $this->dir = $dir;
        $this->trigger = $trigger;
        $this->hub = $hub;
        $this->eventDispatcher = $eventDispatcher;
        $this->entityFactory = $entityFactory;
        $this->testDTOFactory = $testDTOFactory;
        $this->docker = $docker;
        $this->serviceRepository = $serviceRepository;
        $this->testRepository = $testRepository;
        $this->connection = $connection;
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
     * @Route("/get-all-uuids", name="get_all_uuids")
     * @param GetMicroServiceApplication $application
     *
     * @return JsonResponse
     */
    public function getAllUuids(GetMicroServiceApplication  $application)
    {
        return new JsonResponse($application->getAllUuids());
    }

    /**
     * @Route("/test", name="test")
     * @param TestDTO $testDTO
     *
     * @return Response
     */
    public function test(TestDTO $testDTO)
    {
        //./client.php 'http://service-test-lab-new.local/endpoint' 'Hej udało się 3425345!' 'Bars'
        $uuid = uniqid();
        $this->trigger->runRequest(
            $this->docker->findDockerFileDir($testDTO->getUuid()),
            $this->docker->createImagePrefix($uuid),
            $this->docker->createContainerPrefix($uuid),
            $testDTO
        );

        return new Response($this->hub->compare($testDTO));
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
        $this->saveTestApplication->save($testDTO);
        $this->eventDispatcher->dispatch(new AfterSavingTestEvent($testDTO->getUuid()), AfterSavingTestEvent::NAME);
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
        $this->connection->make($uuid1, $uuid2);
        return new Response();
    }

    /**
     * @Route("/endpoint", name="endpoint")
     * @param Request $request
     *
     * @return Response
     */
    public function endpoint(Request $request)
    {
        $this->hub->receiveRequest($request->headers->get('X-Foo'), $request->getContent());

        $uuid = uniqid();

        if(!empty($uuid2 = $this->connection->getNextUuid($request->headers->get('X-Foo')))) {
            $this->trigger->runRequest(
                $this->docker->findDockerFileDir($uuid2),
                $this->docker->createImagePrefix($uuid),
                $this->docker->createContainerPrefix($uuid),
                $this->testDTOFactory->create($this->testRepository->findByHash($uuid2), $request->getContent())
            );
        }

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
        $uuid = uniqid();

        $this->saveApplication->save(
            new UploadedFileAdapter($request->files->all()['files']),
            $this->dir->sureTargetDirExists($this->getParameter('uploaded_directory') . '/' . $uuid),
            new DateTime()
        );
        $this->eventDispatcher->dispatch(new AfterSavingService($uuid), AfterSavingService::NAME);
        return new Response($uuid);
    }

    /**
     * @Route("/deploy", name="deploy")
     * @param Request $request
     *
     * @return Response
     */
    public function deploy(Request $request)
    {
        $this->deployApplication->deploy(
            (string)$this->serviceRepository->findByHash($request->getContent())->getId(),
            $this->dir->sureTargetDirExists($this->getParameter('unpacked_directory') . '/' . $request->getContent()),
            Docker::IMAGE_PREFIX,
            Docker::CONTAINER_PREFIX
        );
        $this->eventDispatcher->dispatch(
            new SaveStatusEvent($this->entityFactory->createStatusEntity($request->getContent(), 'service_deployed', new DateTime())),
            SaveStatusEvent::NAME
        );
        $this->eventDispatcher->dispatch(
            new AfterSavingService($request->getContent()),
            AfterSavingService::NAME
        );
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
        return new JsonResponse(
            array_map(
                function (Status $entity) {
                    return $entity->asArray();
                    },
                $getStatus->getByHash($request->getContent())
            )
        );
    }

    /**
     * @Route("/c3/report/{suffix}", name="c3")
     * @param string $suffix
     *
     * @return Response
     */
    public function c3(string $suffix)
    {
        return new Response();
    }
}
