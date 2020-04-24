<?php namespace Integration\App\Framework\Command;

use App\AppCore\Domain\Service\CommandInterface;
use App\Framework\Service\Command\RunCommand;

class RunCommandTest extends \Codeception\Test\Unit
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

        $command = new RunCommand($containerName, $imageName);

        $this->tester->assertInstanceOf(CommandInterface::class, $command);
        $this->tester->assertEquals("docker run --name $containerName --rm -it -d $imageName:latest",$command->command());
    }
}
