<?php namespace Integration\Framework\Factory;

use App\AppCore\Domain\Repository\uServiceEntityInterface;
use App\Framework\Entity\UService;
use App\Framework\Factory\EntityFactory;

class EntityFactoryTest extends \Codeception\Test\Unit
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
        $factory = new EntityFactory();

        $file = 'file';
        $movedToDir = 'dir';
        $this->tester->assertInstanceOf(uServiceEntityInterface::class, $factory->createService($file, $movedToDir));
        $this->tester->assertInstanceOf(UService::class, $factory->createService($file, $movedToDir));
        $this->tester->assertEquals($file, $factory->createService($file, $movedToDir)->getFile());
        $this->tester->assertEquals($movedToDir, $factory->createService($file, $movedToDir)->getMovedToDir());
    }
}
