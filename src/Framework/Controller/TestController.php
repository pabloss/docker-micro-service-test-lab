<?php
declare(strict_types=1);

namespace App\Framework\Controller;

use App\AppCore\Application\Save\SaveTestApplication;
use App\AppCore\Domain\Actors\Factory\TestDTOFactoryInterface;
use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Service\Test\Trigger;
use App\Framework\Application\Monitor\Hub;
use App\Framework\Service\Test\Connection;
use App\Framework\Service\Test\Docker;
use App\Framework\Subscriber\Event\AfterSavingTestEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @var TestRepositoryInterface
     */
    private $testRepository;
    /**
     * @var Trigger
     */
    private $trigger;
    /**
     * @var Hub $hub
     */
    private $hub;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

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

    public function __construct(
        TestRepositoryInterface $testRepository,
        Trigger $trigger,
        Hub $hub,
        EventDispatcherInterface $eventDispatcher,
        SaveTestApplication $saveTestApplication,
        TestDTOFactoryInterface $testDTOFactory,
        Docker $docker,
        Connection $connection
    ) {
        $this->saveTestApplication = $saveTestApplication;
        $this->trigger = $trigger;
        $this->hub = $hub;
        $this->eventDispatcher = $eventDispatcher;
        $this->testDTOFactory = $testDTOFactory;
        $this->docker = $docker;
        $this->testRepository = $testRepository;
        $this->connection = $connection;
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
     * @return Response
     */
    public function saveTest(TestDTO $testDTO)
    {
        $this->saveTestApplication->save($testDTO);
        $this->eventDispatcher->dispatch(new AfterSavingTestEvent($testDTO->getUuid()), AfterSavingTestEvent::NAME);
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

}
