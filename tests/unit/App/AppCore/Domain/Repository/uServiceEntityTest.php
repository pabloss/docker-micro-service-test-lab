<?php namespace App\AppCore\Domain\Repository;

class uServiceEntityTest extends \Codeception\Test\Unit
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
        $id = 'id';
        $movedToDir = 'movedToDir';
        $file = 'file';
        $uuid = '11111';
        $test = new TestEntity($uuid, 'requestedBody', $id.'OfTestEntity');

        // When
        $entity = new uServiceEntity($movedToDir, $file, $uuid, $id);
        $entity->setTest($test);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($file, $entity->file());
        $this->tester->assertEquals($movedToDir, $entity->movedToDir());
        $this->tester->assertEquals($test, $entity->getTest());
    }

    // tests
    public function testSomeFeatureWithNull()
    {
        // Given
        $id = null;
        $movedToDir = 'movedToDir';
        $file = 'file';
        $uuid = '11111';
        $test = new TestEntity($uuid, 'requestedBody', $id.'OfTestEntity');

        // When
        $entity = new uServiceEntity($movedToDir, $file, $uuid, $id);
        $entity->setTest($test);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($file, $entity->file());
        $this->tester->assertEquals($movedToDir, $entity->movedToDir());
        $this->tester->assertEquals($test, $entity->getTest());
    }
}
