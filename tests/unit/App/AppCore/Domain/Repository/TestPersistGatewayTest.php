<?php namespace App\AppCore\Domain\Repository;

use Codeception\Util\Autoload;
use Integration\Stubs\TestPersistGateway;

class TestPersistGatewayTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/../../../../Integration/Stubs/');
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        // Given
        $id = 'id';
        $uuid = 'uuid';
        $requestedBody = 'test_body';
        $testEntity = new TestEntity($uuid, $requestedBody, $id);

        $gateway = new TestPersistGateway();

        // When
        $gateway->persist($testEntity);
        $all = $gateway->getAll();

        // Then
        $this->tester->assertEquals($testEntity, \end($all));
        $this->tester->assertEquals($testEntity, $gateway->find($id));
    }
}
