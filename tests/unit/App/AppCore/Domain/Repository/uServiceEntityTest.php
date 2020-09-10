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

        // When
        $entity = new uServiceEntity($movedToDir, $file, $id);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($file, $entity->getFile());
        $this->tester->assertEquals($movedToDir, $entity->movedToDir());
    }

    // tests
    public function testSomeFeatureWithNull()
    {
        // Given
        $id = null;
        $movedToDir = 'movedToDir';
        $file = 'file';

        // When
        $entity = new uServiceEntity($movedToDir, $file, $id);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($file, $entity->getFile());
        $this->tester->assertEquals($movedToDir, $entity->movedToDir());
    }
}
