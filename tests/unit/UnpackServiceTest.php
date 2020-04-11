<?php

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
        $service = new UnpackService();

        $this->tester->assertInstanceOf(UnpackServiceInterface::class, $service);
    }
}
