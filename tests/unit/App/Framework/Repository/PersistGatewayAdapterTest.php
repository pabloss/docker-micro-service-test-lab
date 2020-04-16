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
        $intiCount = 0;
        $repo = $this->prophesize(UServiceRepository::class);
        $repo->count([])->willReturn($intiCount);
        $em = $this->prophesize(EntityManagerInterface::class);
        $em->getRepository(UService::class)->willReturn($repo);

        $adapter = new PersistGatewayAdapter($em->reveal());
        $this->tester->assertEquals(1, $adapter->nextId());
    }

    public function testPersist()
    {
        $id = 'id';
        $entity = new uServiceEntity($id, 'movedToDir', 'file');
        $em = $this->prophesize(EntityManagerInterface::class);
        $adapter = new PersistGatewayAdapter($em->reveal());
        $em->persist(UService::fromDomainEntity($entity))->shouldBeCalled()->willReturn($id);
        $em->flush()->shouldBeCalled();

        $this->tester->assertEquals($id, $adapter->persist($entity));
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
