<?php namespace Integration\App\AppCore\Domain\Service;

use App\AppCore\Domain\Service\Build\BuildService;
use App\AppCore\Domain\Service\Command\BuildCommand;
use App\AppCore\Domain\Service\Command\CommandCollection;
use App\AppCore\Domain\Service\Command\CommandRunner;
use App\AppCore\Domain\Service\Command\RunCommand;
use App\Framework\Service\Command\Fetcher\Fetcher;
use App\Tests\unit\Integration\Stubs\OutPutAdapter;

class BuildServiceTest extends \Codeception\Test\Unit
{
    const TEST_UPLOADED_DIR = "/../../files/";
    const DATA_DIR = __DIR__ . '/../../../../../../_data/';
    const TEST_UPLOAD_FILE_NAME = 'test.upload';
    const ZIPPED_TEST_UPLOAD_FILE_NAME = 'test.zip';
    const UNPACKED = 'unpacked';
    const PACKED_MICRO_SERVICE = 'packed/micro-service-1.zip';
    const MICRO_SERVICE_1_DOCKERFILE = 'scratch/Dockerfile';

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
        $id = 'id';
        $uuid = \uniqid();

        $imagePrefix = 'test_image';
        $containerPrefix = 'test_container';

        $imageName = $imagePrefix .'_'.$uuid;
        $containerName = $containerPrefix .'_'.$uuid;

        $data = [];
        exec("docker ps --filter 'name=test_container' --format '{{.ID}}'", $data, $resultCode);
        if(!empty($data)){
            $this->tester->runShellCommand("docker rm  $(docker ps --filter 'name={$containerPrefix}' --format '{{.ID}}' -a) -f", false);
        }
        $data = [];
        exec("docker images 'test_image*' --format '{{.ID}}'", $data, $resultCode);
        if(!empty($data)){
            $this->tester->runShellCommand("docker rmi $(docker images '{$imagePrefix}*' --format '{{.ID}}') -f", false);
        }

        $newDir = self::DATA_DIR . self::UNPACKED . '/' . $id;
        $dockerFilePath = $newDir.'/'.self::MICRO_SERVICE_1_DOCKERFILE;

        $buildCommand = new BuildCommand($dockerFilePath, $imageName);
        $runCommand = new RunCommand($containerName, $imageName);

        $collection = new CommandCollection();
        $collection->addCommand($buildCommand);
        $collection->addCommand($runCommand);
        $service = new BuildService(new CommandRunner(new Fetcher(), new OutPutAdapter()));

        $service->build($collection);

        $this->tester->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerName' --format '{{.ID}}')", false);
        $this->tester->seeInShellOutput('true'); ///-- DZIAŁA!!!
        $this->tester->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerName' --format '{{.ID}}' -a) | wc -l", false);
        $this->tester->seeInShellOutput('1'); ///-- DZIAŁA!!!
    }
}
