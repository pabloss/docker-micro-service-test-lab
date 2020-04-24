<?php

namespace Integration\App\AppCore\Application;

use App\AppCore\Application\DeployApplication;
use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\BuildService;
use App\AppCore\Domain\Service\UnpackService;
use App\Framework\Service\Command\BuildCommand;
use App\Framework\Service\Command\CommandCollection;
use App\Framework\Service\Command\CommandFactory;
use App\Framework\Service\Command\CommandRunner;
use App\Framework\Service\Command\RunCommand;
use App\Framework\Service\UnpackAdapter;
use App\MixedContext\Domain\Service\Files\Dir;
use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;

class DeployApplicationTest extends \Codeception\Test\Unit
{
    const TEST_UPLOADED_DIR = "/../../files/";
    const DATA_DIR = __DIR__ . '/../../../../../_data/';
    const TEST_UPLOAD_FILE_NAME = 'test.upload';
    const ZIPPED_TEST_UPLOAD_FILE_NAME = 'test.zip';
    const UNPACKED = 'unpacked';
    const PACKED_MICRO_SERVICE = 'packed/scratch.zip';
    const MICRO_SERVICE_1_DOCKERFILE = 'scratch/Dockerfile';

    /**
     * @var \UnitTester
     */
    protected $tester;


    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__ . '/../../../../Integration/Stubs/');
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
        $service = new BuildService(new CommandRunner());

        /**
         * 1. Deploy application ma robić unppack
         *      - stosując zależność UnpackServiceInterface oraz Repo: rozpakuj (do nowej lokalizcji) i zapisz do bazy
         * 2. robić build
         */
        $id = 'id';
        // Given
        $repo = new uServiceRepository(new PersistGateway(), new DomainEntityMapper());
        $application = new DeployApplication(
            new UnpackService(new UnpackAdapter(new \ZipArchive())),
            $service,
            new Dir(),
            new CommandFactory(),
            $repo
        ); //Framework

        // When
        $repo->persist(new uService(self::DATA_DIR . self::PACKED_MICRO_SERVICE, self::DATA_DIR));
        if(!\file_exists($newDir)){
            \mkdir($newDir);
        }
        $application->deploy($id, $newDir, 'new_image_prefix', $containerPrefix);


        // Then
        $this->tester->assertFileExists($newDir . '/' . self::MICRO_SERVICE_1_DOCKERFILE);
        $this->tester->assertEquals($newDir, $repo->find($id)->unpacked());
        $this->tester->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerPrefix' --format '{{.Image}} {{.Names}}')", false);
        $this->tester->seeInShellOutput('true'); ///-- DZIAŁA!!!
        $this->tester->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerPrefix' --format '{{.Image}} {{.Names}}' -a) | wc -l", false);
        $this->tester->seeInShellOutput('1'); ///-- DZIAŁA!!!
    }
}
