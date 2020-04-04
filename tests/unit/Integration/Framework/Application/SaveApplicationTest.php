<?php namespace Integration\Framework\Application;

use App\AppCore\Application\SaveApplication;
use App\AppCore\Domain\Repository\DomainEntityMapper;
use App\AppCore\Domain\Repository\uServiceRepository;
use App\AppCore\Domain\Service\SaveDomainService;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Factory\FileFactory;
use App\Framework\Files\FileAdapter;
use App\Framework\Persistence\PersistGatewayAdapter;
use App\Framework\Service\SaveToFileSystemService;
use Codeception\Util\Autoload;
use Integration\Stubs\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveApplicationTest extends \Codeception\Test\Unit
{
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
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/../../Stubs/');
        $fileToSave = __DIR__ . '/../../../../_data/save_test';
        $targetDir =  __DIR__ . '/../../../../_data/target_dir';
        /**
         * Domena ma użyć interfacw wraz z frameworkiem by zapisać
         * do bazy
         * i na dysk
         */
        $em =
            $this->tester->grabService('doctrine.orm.entity_manager');;
        $application = new FrameworkSaveApplication(
            new SaveApplication(
                new FileFactory(),
                new SaveToFileSystemService(),
                new SaveDomainService(
                    $targetDir,
                    new uServiceRepository(new PersistGatewayAdapter($em), new DomainEntityMapper())
                )
            )
        );
        $application->save(new File($fileToSave), $targetDir);

        $id = $this->tester->grabFromDatabase('u_service', 'id', [
            'file' => \basename($fileToSave),
        ]);
        $this->tester->seeInDatabase('u_service',
            [
                'file' => \basename($fileToSave),
                'moved_to_dir' => \basename($targetDir). $id
            ]
            );
        $this->tester->seeFileFound(\basename($fileToSave), $targetDir);

        \file_put_contents($fileToSave, '');
    }
}
