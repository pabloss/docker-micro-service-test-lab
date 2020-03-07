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
        $entity = new uServiceEntity($id, $movedToDir, $file);

        // Then
        $this->tester->assertEquals($id, $entity->id());
        $this->tester->assertEquals($file, $entity->file());
        $this->tester->assertEquals($movedToDir, $entity->movedToDir());
    }
}
