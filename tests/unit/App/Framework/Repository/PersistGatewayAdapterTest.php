<?php

use App\Framework\Entity\UService;
use App\Framework\Persistence\PersistGatewayAdapter;
use App\Framework\Repository\UServiceRepository;
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
        $entity= new UService();
        $em = $this->prophesize(EntityManagerInterface::class);
        $adapter = new PersistGatewayAdapter($em->reveal());
        $em->persist($entity)->shouldBeCalled();
        $em->flush()->shouldBeCalled();

        $adapter->persist($entity);
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
