<?php
namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Service\Build\BuildService;
use App\AppCore\Domain\Service\Command\CommandInterface;
use App\AppCore\Domain\Service\Command\CommandRunnerInterface;
use App\AppCore\Domain\Service\Command\CommandsCollectionInterface;

class BuildServiceTest extends \Codeception\Test\Unit
{
    const TEST_UPLOADED_DIR = "/../../files/";
    const DATA_DIR = __DIR__ . '/../../../../../_data/';
    const TEST_UPLOAD_FILE_NAME = 'test.upload';
    const ZIPPED_TEST_UPLOAD_FILE_NAME = 'test.zip';
    const UNPACKED = 'unpacked';
    const PACKED_MICRO_SERVICE = 'packed/micro-service-1.zip';
    const MICRO_SERVICE_1_DOCKERFILE = 'micro-service-1/Dockerfile';

    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $uuid = \uniqid();
        $imageName = 'test_image'.'_'.$uuid;
        $containerName = 'test_container'.'_'.$uuid;

        $id = 'id';
        $newDir = self::DATA_DIR . self::UNPACKED . '/' . $id;
        $dockerFilePath = $newDir.'/'.self::MICRO_SERVICE_1_DOCKERFILE;

        // create commands
        // $dockerFilePath, $imageName <= should be in constructor
        $buildCommand = $this->prophesize(CommandInterface::class);
        $buildCommand->willBeConstructedWith([$dockerFilePath, $imageName]);
        $buildCommand->command()->willReturn("docker build -f $dockerFilePath -t $imageName .")->shouldBeCalled();

        // $containerName, $imageName <= should be in constructor
        $runCommand = $this->prophesize(CommandInterface::class);
        $runCommand->willBeConstructedWith([$containerName, $imageName]);
        $runCommand->command()->willReturn("docker run --name $containerName -it $imageName:latest")->shouldBeCalled();

        // add to collection
        $commandsCollection = $this->prophesize(CommandsCollectionInterface::class);
        $commandsCollection->addCommand($buildCommand->reveal())->shouldBeCalled();
        $commandsCollection->addCommand($runCommand->reveal())->shouldBeCalled();
        $commandsCollection->getCommand(0)->willReturn($buildCommand->reveal())->shouldBeCalled();
        $commandsCollection->getCommand(1)->willReturn($runCommand->reveal())->shouldBeCalled();

        $commandsCollection->reveal()->addCommand($buildCommand->reveal());
        $commandsCollection->reveal()->addCommand($runCommand->reveal());

        // run them
        $commandRunner = $this->prophesize(CommandRunnerInterface::class);
        $commandRunner->willBeConstructedWith([$commandsCollection->reveal()]);
        $commandRunner->run($commandsCollection->reveal())->will(function ($args){
            $args[0]->getCommand(0)->command();
            $args[0]->getCommand(1)->command();
        })->shouldBeCalled();

        $service = new BuildService($commandRunner->reveal());

        /**
         * 1. Run: docker build -f $dockerFilePath -t $imageName .
         * 2. and run: docker run --name $containerName -it $imageName:latest
         * 3. output should be: 'true' for `docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerName' --format '{{.ID}}')`
         * 4. and '1' for `docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerName' --format '{{.ID}}' -a) | wc -l`
         */
        $service->build($commandsCollection->reveal());

        /**
         * - we don't check output - incrementally or at once - we don't assume behaviour or cli
         * - we only check the command text and its arguments
         */


    }
}
