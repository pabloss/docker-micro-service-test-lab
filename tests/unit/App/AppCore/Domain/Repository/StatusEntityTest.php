<?php namespace App\AppCore\Domain\Repository;

use App\Framework\Entity\Status;

class StatusEntityTest extends \Codeception\Test\Unit
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
    // tests
    public function testSomeFeature()
    {
        // Given
        $id = '10';
        $uuid = 'uuid';
        $statusString = 'test_status';
        $when = new \DateTime('2020-08-14 12:33:45');

        // When
        $entity = new Status();
        $entity->setId((int) $id);
        $entity->setUuid($uuid);
        $entity->setStatusName($statusString);
        $entity->setCreated($when);

        // Then
        $this->tester->assertEquals($id, $entity->getId());
        $this->tester->assertEquals($uuid, $entity->getUuid());
        $this->tester->assertEquals($statusString, $entity->getStatusName());
        $this->tester->assertEquals($when, $entity->getCreated());
    }
}
