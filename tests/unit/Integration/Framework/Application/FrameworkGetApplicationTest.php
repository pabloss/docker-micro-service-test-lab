<?php

namespace Integration\Framework\Application;


use App\AppCore\Application\SaveApplication;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\GetFileService;
use App\AppCore\Domain\Service\SaveDomainService;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Factory\FileFactory;
use App\Framework\Persistence\PersistGatewayAdapter;
use App\Framework\Service\SaveToFileSystemService;
use App\Framework\Application\FrameworkGetApplication;
use Codeception\Util\Autoload;
use Integration\Stubs\File;

class FrameworkGetApplicationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $fileToSave;
    /**
     * @var PersistGatewayInterface
     */
    private $gateway;
    private $repo;
    private $getFileService;
    private $targetDir;

    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/../../Stubs/');
        $this->fileToSave = __DIR__ . '/../../../../_data/save_test';
        $this->targetDir = __DIR__ . '/../../../../_data/target_dir';
        /**
         * Domena ma użyć interfacw wraz z frameworkiem by zapisać
         * do bazy
         * i na dysk
         */
        $em =
            $this->tester->grabService('doctrine.orm.entity_manager');;
        $this->gateway = new PersistGatewayAdapter($em);
        $this->repo = new uServiceRepository($this->gateway, new DomainEntityMapper());
        $application = new FrameworkSaveApplication(
            new SaveApplication(
                new SaveToFileSystemService(), new SaveDomainService(
                    $this->targetDir,
                    $this->repo
                )
            )
        );
        $this->getFileService = new GetFileService($this->repo);
        $application->save(new File($this->fileToSave), $this->targetDir);
    }

    protected function _after()
    {
        \file_put_contents($this->fileToSave, '');
    }

    // tests
    public function testSomeFeature()
    {
        /**
         * 1. wpisz $id
         * 2. masz dostać plik
         * 3. użyj domeny
         */
        $application = new FrameworkGetApplication($this->getFileService);

        //użyję get service by dostać domenową klasę i stamtąd będę miał \SpFileInfo

        $this->tester->assertEquals(
            \basename($this->targetDir).($this->gateway->nextId()-1).'/'.\basename($this->fileToSave)
            , $application->getFile($this->gateway->nextId()-1)->getPathName());
    }
}
