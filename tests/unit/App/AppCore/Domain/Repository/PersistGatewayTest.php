<?php namespace App\AppCore\Domain\Repository;

use Codeception\Util\Autoload;

class PersistGatewayTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        Autoload::addNamespace(__NAMESPACE__, __DIR__);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        // Given
        $id = 'id';
        $file = 'test.txt';
        $movedToDir = 'dirName';
        $uServiceEntity = new uServiceEntity($id, $movedToDir . $id, $file);

        $gateway = new PersistGateway();

        // When
        $gateway->persist($uServiceEntity);
        $all = $gateway->getAll();

        // Then
        $this->tester->assertEquals($uServiceEntity, \end($all));

        $this->tester->assertEquals($uServiceEntity, $gateway->find($id));
    }
}
