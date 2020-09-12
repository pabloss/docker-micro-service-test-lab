<?php namespace Integration\Framework\Application;

use App\AppCore\Domain\Service\Save\SaveDomainService;
use App\Framework\Application\FrameworkSaveApplication;
use App\Framework\Entity\UService;
use App\Framework\Factory\EntityFactory;
use App\Framework\Files\FileAdapter;
use App\Framework\Service\SaveToFileSystemService;
use Codeception\Util\Autoload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;

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
        \file_put_contents($fileToSave, '');
        /**
         * Domena ma użyć interfacw wraz z frameworkiem by zapisać
         * do bazy
         * i na dysk
         */
        /** @var EntityManagerInterface $em */
        $em =
            $this->tester->grabService('doctrine.orm.entity_manager');;
        $factory = new EntityFactory();
        $application = new FrameworkSaveApplication(
            new \App\AppCore\Application\Save\SaveApplication(
                new SaveToFileSystemService(), new SaveDomainService(
                    $targetDir,
                    $em->getRepository(UService::class),
                    $factory
                )
            )
        );
        $application->save(new FileAdapter(new File($fileToSave)), $targetDir);

        $this->tester->seeInDatabase('u_service',
            [
                'file' => $fileToSave,
                'moved_to_dir' => $targetDir
            ]
            );
        $this->tester->seeFileFound(\basename($fileToSave), $targetDir);

        \file_put_contents($fileToSave, '');
    }
}
