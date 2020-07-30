<?php

namespace App\Framework\Repository;

use App\AppCore\Domain\Repository\uServiceEntity;
use App\Framework\Entity\UService;
use App\Framework\Persistence\PersistGatewayAdapter;
use Doctrine\ORM\EntityManagerInterface;

class PersistGatewayAdapterTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testNextId()
    {
        $repo = $this->prophesize(UServiceRepository::class);
        $repo->findAll()->willReturn([]);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(UService::class)->willReturn($repo->reveal());

        $adapter = new PersistGatewayAdapter($em->reveal());
        $this->tester->assertEquals(0, $adapter->nextId());
    }

    public function testPersist()
    {
        $id = 'id';
        $uuid = '1111';
        $entity = new uServiceEntity('movedToDir', 'file', $uuid, $id);
        $UService = UService::fromDomainEntity($entity, null);

        $repo = $this->prophesize(UServiceRepository::class);
        $repo->find($id)->willReturn($UService);

        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(UService::class)->willReturn($repo->reveal());
        $em->persist($UService)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $adapter = new PersistGatewayAdapter($em->reveal());
        $adapter->persist($entity);
        $this->tester->assertEquals($UService, $repo->reveal()->find($id));
        $this->tester->assertEquals($uuid, $repo->reveal()->find($id)->getUuid());
    }

    public function testPersistNewEntity()
    {
        $id = 'id';
        $uuid = '1111';
        $entity = new uServiceEntity('movedToDir', 'file', $uuid, null);

        $repo = $this->prophesize(UServiceRepository::class);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(UService::class)->willReturn($repo->reveal());

        $UServiceEntity = UService::fromDomainEntity($entity, null);
        $em->persist($UServiceEntity)->shouldBeCalled()->willReturn($id);
        $em->flush()->shouldBeCalled();

        $adapter = new PersistGatewayAdapter($em->reveal());
        $adapter->persist($entity);

        $this->tester->assertEquals($uuid, $entity->uuid());
    }


    public function testGetAll()
    {
        $repo = $this->prophesize(UServiceRepository::class);
        $repo->findAll()->willReturn([]);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(UService::class)->willReturn($repo);

        $adapter = new PersistGatewayAdapter($em->reveal());
        $this->tester->assertEquals([], $adapter->getAll());
    }
}
