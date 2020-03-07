<?php namespace App\AppCore\Domain\Actors;

class uServiceTest extends \Codeception\Test\Unit
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
        $id = 'test';
        $file = 'fileName';
        $movedToDir = 'movedToDir';

        // When
        $uService = new uService($file, $movedToDir);
        $uService->setId($id);

        // Then
        $this->tester->assertEquals($id, $uService->id());
        $this->tester->assertEquals($file, $uService->fileName());
        $this->tester->assertEquals($movedToDir, $uService->movedToDir());

    }
}
