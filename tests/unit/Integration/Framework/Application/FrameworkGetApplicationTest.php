<?php

namespace Integration\Framework\Application;


use App\AppCore\Application\Save\SaveApplication;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Service\GetFileService;
use App\AppCore\Domain\Service\Save\SaveDomainService;
use App\Framework\Application\FrameworkGetApplication;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Entity\UService;
use App\Framework\Factory\EntityFactory;
use App\Framework\Service\SaveToFileSystemService;
use Codeception\Util\Autoload;
use Doctrine\ORM\EntityManagerInterface;
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
    /** @var TestRepositoryInterface */
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
        /** @var EntityManagerInterface $em */
        $em =
            $this->tester->grabService('doctrine.orm.entity_manager');;
        $this->repo = $em->getRepository(UService::class);
        $factory = new EntityFactory();
        $application = new FrameworkSaveApplication(
            new SaveApplication(
                new SaveToFileSystemService(), new SaveDomainService(
                    $this->targetDir,
                    $this->repo,
                    $factory
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

        $all = $this->repo->all();
        $this->tester->assertEquals(
            '/home/pavulon/code/docker-micro-service-test-lab-new/tests/unit/Integration/Framework/Application/../../../../_data/target_dir//home/pavulon/code/docker-micro-service-test-lab-new/tests/unit/Integration/Framework/Application/../../../../_data/save_test'
            , $application->getFile(\end($all)->getId())->getPathName());
    }
}
