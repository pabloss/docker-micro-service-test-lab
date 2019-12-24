<?php namespace App\AppCore\Domain\Application\Stages\Deploy;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use Codeception\Stub\Expected;

class RunProcessTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /** @var RunProcess */
    private $runProcess;

    protected function _before()
    {
        /** @var CommandProcessor $commandProcessor */
        $commandProcessor = $this->make(CommandProcessor::class, [
            'processRealTimeOutput' => Expected::atLeastOnce(),
        ]);
        $this->runProcess = new RunProcess($commandProcessor);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $payload = [
            'container' => '',
            'tag' => '',
            'index' => '',
        ];
        $buildProcess = $this->runProcess;
        $buildProcess($payload);
    }
}
