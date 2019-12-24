<?php namespace App\AppCore\Domain\Application\Stages\Test;

use App\AppCore\Domain\Application\Stages\Deploy\UpProcess;
use App\AppCore\Domain\Service\Command\CommandProcessor;
use Codeception\Stub\Expected;

class TestProcessTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /** @var TestProcess */
    private $testProcess;

    protected function _before()
    {
        /** @var CommandProcessor $commandProcessor */
        $commandProcessor = $this->make(CommandProcessor::class, [
            'processRealTimeOutput' => Expected::atLeastOnce(),
        ]);
        $this->testProcess = new TestProcess($commandProcessor);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $payload = [
            'file' =>'',
            'index' =>'',
        ];
        $buildProcess = $this->testProcess;
        $buildProcess($payload);
    }
}
