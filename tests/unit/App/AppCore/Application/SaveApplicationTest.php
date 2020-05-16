<?php namespace App\AppCore\Application;

use App\AppCore\Application\Save\SaveApplication;
use App\AppCore\Application\Save\SaveToFileSystemInterface;
use App\AppCore\Domain\Actors\FileInterface;
use App\AppCore\Domain\Service\Save\SaveDomainServiceInterface;

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
        // domenowe aplikacje nie mogą zależeć od szczególnych przypadków rozwiazań
        // mają obrazować jedynie domenę

        $movedToDir = 'dir';
        $file = 'file';
        $uploadedFile = $this->prophesize(FileInterface::class);
        $uploadedFile->getPath()->willReturn($file);
        $uploadedFile->getBasename()->willReturn($file);

        $saveToFileSystem = $this->prophesize(SaveToFileSystemInterface::class);
        $saveToFileSystem->move($movedToDir, $uploadedFile)->willReturn($uploadedFile)->shouldBeCalled();

        $saveDomainService = $this->prophesize(SaveDomainServiceInterface::class);
        $saveDomainService->save($uploadedFile->reveal()->getBasename())->shouldBeCalled();

        $app = new SaveApplication($saveToFileSystem->reveal(), $saveDomainService->reveal());

        $app->save($movedToDir, $uploadedFile->reveal());
    }
}
