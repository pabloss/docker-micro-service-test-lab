<?php namespace Integration\App\AppCore\Domain\Service;

use App\AppCore\Domain\Service\BuildService;

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
        $this->tester->runShellCommand(" docker rmi $(docker images '$imageName*' --format '{{.ID}}') -f", false);
        $this->tester->runShellCommand("docker rm  $(docker ps --filter 'name=$containerName' --format '{{.ID}}')", false);

        $id = 'id';
        $service = new BuildService();
        $newDir = self::DATA_DIR . self::UNPACKED . '/' . $id;
        $service->build($newDir.'/'.self::MICRO_SERVICE_1_DOCKERFILE, $imageName, $containerName);

        $this->tester->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerName' --format '{{.ID}}')", false);
        $this->tester->seeInShellOutput('true'); ///-- DZIAŁA!!!
        $this->tester->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerName' --format '{{.ID}}' -a) | wc -l", false);
        $this->tester->seeInShellOutput('1'); ///-- DZIAŁA!!!
    }
}
