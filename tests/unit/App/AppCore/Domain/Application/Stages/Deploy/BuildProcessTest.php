<?php namespace App\AppCore\Domain\Application\Stages\Deploy;


use App\AppCore\Domain\Service\Command\CommandProcessor;
use Codeception\Stub\Expected;

class BuildProcessTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var BuildProcess */
    private $buildProcess;
    
    protected function _before()
    {
        /** @var CommandProcessor $commandProcessor */
        $commandProcessor = $this->make(CommandProcessor::class, [
            'processRealTimeOutput' => Expected::atLeastOnce(),
        ]);
        $this->buildProcess = new BuildProcess($commandProcessor);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $payload = [
            'tag'  => '',
            'target_dir'  => '',
            'index'  => '',
        ];
        $buildProcess = $this->buildProcess;
        $buildProcess($payload);
    }
}
