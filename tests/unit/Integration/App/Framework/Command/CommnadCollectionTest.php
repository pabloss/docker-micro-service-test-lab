<?php namespace Integration\App\Framework\Command;

use App\AppCore\Domain\Service\CommandsCollectionInterface;
use App\Framework\Service\Command\RunCommand;
use App\Framework\Service\Command\CommandCollection;

class CommnadCollectionTest extends \Codeception\Test\Unit
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

        $buildCommand = new RunCommand($containerName, $imageName);
        $runCommand = new RunCommand($containerName, $imageName);

        $collection = new CommandCollection();
        $collection->addCommand($buildCommand);
        $collection->addCommand($runCommand);


        $this->tester->assertInstanceOf(CommandsCollectionInterface::class, $collection);
        $this->tester->assertEquals($buildCommand, $collection->getCommand(0));
        $this->tester->assertEquals($runCommand, $collection->getCommand(1));
        $this->tester->assertEquals(2, $collection->count());


    }
}
