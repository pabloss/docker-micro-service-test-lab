<?php namespace Integration;

use App\Entity\Connection;
use App\Framework\Service\MakeConnection;
use Doctrine\ORM\EntityManagerInterface;

class MakeConnectionTest extends \Codeception\Test\Unit
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
        /** @var EntityManagerInterface $em */
        $em =
            $this->tester->grabService('doctrine.orm.entity_manager');
        $service = new MakeConnection($em);

        $uniqid1 = \uniqid();
        $uniqid2 = \uniqid();
        $service->make($uniqid1, $uniqid2);

        $connection = $em->getRepository(Connection::class)->findOneBy([
            'uuid1' => $uniqid1,
            'uuid2' => $uniqid2,
        ]);

        $this->tester->assertEquals($uniqid1, $connection->getUuid1());
        $this->tester->assertEquals($uniqid2, $connection->getUuid2());
    }
}
