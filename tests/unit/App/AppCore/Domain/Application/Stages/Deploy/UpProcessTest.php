<?php namespace App\AppCore\Domain\Application\Stages\Deploy;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use Codeception\Stub\Expected;

class UpProcessTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /** @var UpProcess */
    private $upProcess;

    protected function _before()
    {
        /** @var CommandProcessor $commandProcessor */
        $commandProcessor = $this->make(CommandProcessor::class, [
            'processRealTimeOutput' => Expected::atLeastOnce(),
        ]);
        $this->upProcess = new UpProcess($commandProcessor);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $payload =[
            'file' => 'tests/_data/',
            'index' => 'tests/_data/',
        ];
        $buildProcess = $this->upProcess;
        $buildProcess($payload);
    }
}
