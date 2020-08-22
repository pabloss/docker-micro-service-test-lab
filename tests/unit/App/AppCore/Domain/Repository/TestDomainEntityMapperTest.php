<?php namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\Test;

class TestDomainEntityMapperTest extends \Codeception\Test\Unit
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
        $id = 'id';
        $uuid = '1111';
        $requestedBody = 'test_body';
        $mapper  = new TestDomainEntityMapper();
        $test = new Test($uuid, $requestedBody);
        $testEntity = $mapper->domain2Entity($id, $test);

        $this->tester->assertInstanceOf(TestEntity::class, $testEntity);
        $this->tester->assertEquals($id, $testEntity->id());
        $this->tester->assertEquals($uuid, $testEntity->uuid());
        $this->tester->assertEquals($requestedBody, $testEntity->requestedBody());

        $this->tester->assertEquals($test, $mapper->entity2Domain($testEntity));
    }
}
