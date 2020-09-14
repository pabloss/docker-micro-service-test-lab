<?php namespace App\AppCore\Domain\Repository;

use App\Framework\Factory\EntityFactory;
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
        $factory = new EntityFactory();
        $testEntity = $factory->createTest($uuid, $requestedBody, $requestedBody,  'header', 'url', 'script');
        $testEntity->setId($id);

        $gateway = new TestPersistGateway();

        // When
        $gateway->persist($testEntity, $id);
        $all = $gateway->all();

        // Then
        $this->tester->assertEquals($testEntity, \end($all));
        $this->tester->assertEquals($testEntity, $gateway->find($id));
    }
}
