<?php namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Actors\uServiceInterface;

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

//    // tests
//    public function testSomeFeature()
//    {
//        // Given
//        $id = 'id';
//        $file = 'file';
//        $movedToDir = 'movedToDir';
//        $uServiceEntity = new uServiceEntity($movedToDir . $id, $file, $id);
//        $persistGateway = $this->prophesize(PersistGatewayInterface::class);
//        $persistGateway->nextId()->willReturn('id');
//        $persistGateway->getAll()->willReturn([$uServiceEntity]);
//        $persistGateway->persist($uServiceEntity)->shouldBeCalled()->willReturn($id);
//        $persistGateway->find($id)->willReturn($uServiceEntity)->shouldBeCalled();
//        $domain = new uService($file, $movedToDir);
//
//        $mapper = $this->prophesize(DomainEntityMapperInterface::class);
//        $mapper->domain2Entity($id, $domain)->willReturn($uServiceEntity);
//        $mapper->entity2Domain($uServiceEntity)->willReturn($domain);
//        $repo = new uServiceRepository($persistGateway->reveal(), $mapper->reveal());  //jeśli repo zależy od mappera to będę mógł zrobić mocka do entity
//
//        // When
//        $lastId = $repo->persist($domain, null);
//
//        // Then
//        $this->tester->assertInstanceOf(uServiceInterface::class, $repo->find($lastId));
//        $this->tester->assertNotEmpty($lastId);
//        $this->tester->assertEquals($movedToDir.$lastId, $repo->find($lastId)->movedToDir());
//        $this->tester->assertEquals($file, $repo->find($lastId)->file());
//
//        $this->tester->assertEquals($domain, $repo->find($lastId));
//
//    }

    // tests
    public function testSomeFeatureWithNull()
    {
        // Given
        $nextId = 'nextId';
        $file = 'file';
        $movedToDir = 'movedToDir';
        $domain = new uService($file, $movedToDir);

        $uServiceEntity = new uServiceEntity($movedToDir, $file, null);
        $persistGateway = $this->prophesize(PersistGatewayInterface::class);
        $persistGateway->nextId()->willReturn('nextId');
        $persistGateway->persist($uServiceEntity)->shouldBeCalled();
        $persistGateway->find($nextId)->willReturn($uServiceEntity);


        $mapper = $this->prophesize(DomainEntityMapperInterface::class);
        $mapper->domain2Entity(null, $domain)->willReturn($uServiceEntity);
        $mapper->entity2Domain($uServiceEntity)->willReturn($domain);
        $repo = new uServiceRepository($persistGateway->reveal(), $mapper->reveal());  //jeśli repo zależy od mappera to będę mógł zrobić mocka do entity

        // When
        $repo->persist($domain, null);

        // Then
        $this->tester->assertInstanceOf(uServiceInterface::class, $repo->find($nextId));
        $this->tester->assertEquals($movedToDir, $repo->find($nextId)->movedToDir());
        $this->tester->assertEquals($file, $repo->find($nextId)->file());

        $this->tester->assertEquals($domain, $repo->find($nextId));

    }
}
