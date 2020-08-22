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
        $test = new Test('11111', 'requestedBody');

        // When
        $uService = new uService($file, $movedToDir);
        $uService->setTest($test);

        // Then
        $this->tester->assertEquals($file, $uService->file());
        $this->tester->assertEquals($movedToDir, $uService->movedToDir());
        $this->tester->assertEquals($test, $uService->getTest());

    }
}
