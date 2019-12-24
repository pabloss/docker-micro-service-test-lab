<?php namespace App\AppCore\Domain\Application\Stages\Unpack;

class UnzippedFileParamsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var UnzippedFileParams */
    private $testProcess;

    protected function _before()
    {
        /** @var UnzippedFileParams $commandProcessor */
        $this->testProcess = new UnzippedFileParams('', '');
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $this->assertEquals('', $this->testProcess->getTargetFile());
        $this->assertEquals('', $this->testProcess->getTargetDir());
        $this->assertEquals([
            'target_dir' => '',
            'target_file' => '',
        ], $this->testProcess->toArray());
    }
}
