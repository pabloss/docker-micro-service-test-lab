<?php namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;

class DomainEntityMapperTest extends \Codeception\Test\Unit
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
        $mapper  = new DomainEntityMapper();
        $uService = new uService('file', 'dir');
        $entity = $mapper->domain2Entity('id', $uService);

        $this->tester->assertInstanceOf(uServiceEntity::class, $entity);
        $this->tester->assertEquals('file', $entity->file());
        $this->tester->assertEquals('dir'.'id', $entity->movedToDir());
    }
}
