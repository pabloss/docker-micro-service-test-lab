<?php namespace App\AppCore\Domain\Repository;

use Codeception\Util\Autoload;
use Integration\Stubs\PersistGateway;

class PersistGatewayTest extends \Codeception\Test\Unit
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
        $file = 'test.txt';
        $movedToDir = 'dirName';
        $uuid = '11111';
        $uServiceEntity = new uServiceEntity($movedToDir . $id, $file, $uuid, $id);

        $gateway = new PersistGateway();

        // When
        $gateway->persist($uServiceEntity);
        $all = $gateway->getAll();

        // Then
        $this->tester->assertEquals($uServiceEntity, \end($all));

        $this->tester->assertEquals($uServiceEntity, $gateway->find($id));
        $this->tester->assertEquals($uuid, $gateway->find($id)->uuid());
    }
}
