<?php namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;
use Codeception\Stub;

class uServiceRepositoryTest extends \Codeception\Test\Unit
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
        // Given
        $id = 'id';
        $file = 'file';
        $movedToDir = 'movedToDir';
        $uServiceEntity = new uServiceEntity($id, $movedToDir . $id, $file);
        $persistGateway = $this->prophesize(PersistGatewayInterface::class);
        $persistGateway->nextId()->willReturn('id');
        $persistGateway->getAll()->willReturn([$uServiceEntity]);
        $persistGateway->persist($uServiceEntity)->shouldBeCalled();
        $domain = new uService($file, $movedToDir);

        $mapper = $this->prophesize(DomainEntityMapperInterface::class);
        $mapper->domain2Entity($id, $domain)->willReturn($uServiceEntity);
        $repo = new uServiceRepository($persistGateway->reveal(), $mapper->reveal());  //jeśli repo zależy od mappera to będę mógł zrobić mocka do entity

        // When
        $repo->persist($domain);
        $all = $repo->all();
        $lastEntity = \end($all);

        // Then
        $this->tester->assertInstanceOf(uServiceEntity::class, $lastEntity);
        $this->tester->assertNotEmpty($lastEntity->id());
        $this->tester->assertEquals($movedToDir.$lastEntity->id(), $lastEntity->movedToDir());
        $this->tester->assertEquals($file, $lastEntity->file());
    }
}
