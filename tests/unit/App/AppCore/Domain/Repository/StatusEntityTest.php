<?php namespace App\AppCore\Domain\Repository;

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
        $id = 'ID';
        $uuid = 'uuid';
        $statusString = 'test_status';
        $when = new \DateTime('2020-08-14 12:33:45');

        // When
        $entity = new StatusEntity($uuid, $statusString, $when, $id);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($uuid, $entity->uuid());
        $this->tester->assertEquals($statusString, $entity->statusString());
        $this->tester->assertEquals($when, $entity->when());
    }
}
