<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\Deploy\DeployApplication;
use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Application\Save\FrameworkSaveApplication;
use App\Framework\Entity\UService;
use App\Framework\Service\Files\Dir;
use App\Framework\Service\Files\UploadedFileAdapter;
use App\Framework\Service\Test\Connection;
use App\Framework\Service\Test\Docker;
use App\Framework\Subscriber\Event\AfterSavingService;
use App\Framework\Subscriber\Event\SaveStatusEvent;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseAlias;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
     * @var Dir
     */
    private $dir;
    /**
     * @var uServiceRepositoryInterface
     */
    private $serviceRepository;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var EntityFactoryInterface */
    private $entityFactory;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * AppController constructor.
     *
     * @param FrameworkSaveApplication    $saveApplication
     * @param DeployApplication           $deployApplication
     * @param uServiceRepositoryInterface $serviceRepository
     * @param Dir                         $dir
     * @param EventDispatcherInterface    $eventDispatcher
     * @param EntityFactoryInterface      $entityFactory
     * @param Connection                  $connection
     */
    public function __construct(
        FrameworkSaveApplication $saveApplication,
        DeployApplication $deployApplication,
        uServiceRepositoryInterface $serviceRepository,
        Dir $dir,
        EventDispatcherInterface $eventDispatcher,
        EntityFactoryInterface $entityFactory,
        Connection $connection
    ) {
        $this->saveApplication = $saveApplication;
        $this->deployApplication = $deployApplication;
        $this->dir = $dir;
        $this->eventDispatcher = $eventDispatcher;
        $this->entityFactory = $entityFactory;
        $this->serviceRepository = $serviceRepository;
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
     * @Route("/micro-service/{uuid}", name="get_micro_service")
     *
     * @param UService $UService
     *
     * @return Response
     */
    public function getMicroService(UService $UService)
    {
        return new Response($this->renderView('app/micro-service.html.twig', [
            'uuid' => $UService->getUuid()
        ]));
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
