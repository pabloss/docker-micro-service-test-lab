<?php

use App\AppCore\Domain\Actors\uServiceInterface;
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
        $unpackedDir = 'unpacked';
        $uService = $this->prophesize(uServiceInterface::class);
        $service = new UnpackService();
        $updatedUService = $service->unpack($uService, $unpackedDir.$id);

        $this->tester->assertInstanceOf(UnpackServiceInterface::class, $service);
        $this->tester->assertStringStartsWith($unpackedDir.$id, $updatedUService->unpacked());
    }
}
