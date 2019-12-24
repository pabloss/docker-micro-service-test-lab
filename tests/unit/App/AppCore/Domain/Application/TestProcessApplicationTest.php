<?php namespace App\AppCore\Domain\Application;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use Codeception\Stub\Expected;

class TestProcessApplicationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /** @var TestProcessApplication */
    private $testProcess;

    protected function _before()
    {
        /** @var CommandProcessor $commandProcessor */
        $commandProcessor = $this->make(CommandProcessor::class, [
            'processRealTimeOutput' => Expected::atLeastOnce(),
        ]);
        /** @var Dir $dir */
        $dir = $this->make(Dir::class, [
            'findFile' => Expected::atLeastOnce('tests/_data/')
        ]);
        $this->testProcess = new TestProcessApplication($commandProcessor, $dir);
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $this->testProcess->run( 'tests/_data/');
    }
}
