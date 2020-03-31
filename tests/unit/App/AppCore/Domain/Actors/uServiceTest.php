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
        $file = 'fileName';
        $movedToDir = 'movedToDir';

        // When
        $uService = new uService($file, $movedToDir);

        // Then
        $this->tester->assertEquals($file, $uService->file());
        $this->tester->assertEquals($movedToDir, $uService->movedToDir());

    }
}
