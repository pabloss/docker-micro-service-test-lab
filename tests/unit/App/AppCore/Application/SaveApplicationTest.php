<?php namespace App\AppCore\Application;

use App\AppCore\Domain\Actors\FileInterface;
use App\AppCore\Domain\Service\SaveDomainServiceInterface;

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
        $uploadedFile->getBasename()->willReturn($file);

        $saveToFileSystem = $this->prophesize(SaveToFileSystemInterface::class);
        $saveToFileSystem->move($movedToDir, $uploadedFile)->shouldBeCalled();

        $factory = $this->prophesize(FileFactoryInterface::class);
        $factory->createFile($uploadedFile->reveal()->getBasename())->shouldBeCalled()->willReturn($uploadedFile);

        $saveDomainService = $this->prophesize(SaveDomainServiceInterface::class);
        $saveDomainService->save($uploadedFile->reveal()->getBasename())->shouldBeCalled();

        $app = new SaveApplication($factory->reveal(), $saveToFileSystem->reveal(),  $saveDomainService->reveal());

        $app->save($movedToDir, $uploadedFile->reveal()->getBasename());
    }
}
