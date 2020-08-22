<?php namespace App\AppCore\Domain\Repository;

class TestEntityTest extends \Codeception\Test\Unit
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
        $id = 'ID';
        $uuid = 'uuid';
        $requestedBody = 'test_body';
        // When
        $entity = new TestEntity($uuid, $requestedBody, $id);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($uuid, $entity->uuid());
        $this->tester->assertEquals($requestedBody, $entity->requestedBody());
    }

    // tests
    public function testSomeFeatureWithNull()
    {
        // Given
        $id = null;
        $uuid = 'uuid';
        $requestedBody = 'test_body';
        // When
        $entity = new TestEntity($uuid, $requestedBody, $id);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($uuid, $entity->uuid());
        $this->tester->assertEquals($requestedBody, $entity->requestedBody());
    }
}
