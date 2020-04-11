<?php

use App\AppCore\Domain\Actors\uServiceInterface;
use App\AppCore\Domain\Service\UnpackInterface;
use App\AppCore\Domain\Service\UnpackService;
use App\AppCore\Domain\Service\UnpackServiceInterface;

class UnpackServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    // tests
    public function testSomeFeature()
    {
        $id = 'id';
        $file = 'file';
        $movedToDir = 'movedToDir';
        $unpackedDir = 'unpacked';

        $uService = $this->prophesize(uServiceInterface::class);
        $uService->file()->willReturn($file);
        $uService->movedToDir()->willReturn($movedToDir);
        $uService->setUnpacked($unpackedDir.$id)->will(function ($args) use ($uService, $unpackedDir, $id){
            $uService->unpacked()->willReturn($unpackedDir.$id);
        });

        $unpackLibAdapter = $this->prophesize(UnpackInterface::class);
        $unpackLibAdapter->unpack($uService->reveal()->movedToDir().'/'.$uService->reveal()->file(), $unpackedDir.$id)->shouldBeCalled();

        $service = new UnpackService($unpackLibAdapter->reveal());
        $updatedUService = $service->unpack($uService->reveal(), $unpackedDir.$id);

        $this->tester->assertInstanceOf(UnpackServiceInterface::class, $service);
        $this->tester->assertStringStartsWith($unpackedDir.$id, $updatedUService->unpacked());
    }
}
