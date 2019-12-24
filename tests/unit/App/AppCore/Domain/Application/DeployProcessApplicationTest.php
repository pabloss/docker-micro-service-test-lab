<?php namespace App\AppCore\Domain\Application;

use App\AppCore\Domain\Application\Stages\Test\TestProcess;
use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use Codeception\Stub\Expected;

class DeployProcessApplicationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var DeployProcessApplication */
    private $testProcess;

    protected function _before()
    {
        /** @var CommandProcessor $commandProcessor */
        $commandProcessor = $this->make(CommandProcessor::class, [
            'processRealTimeOutput' => Expected::atLeastOnce(),
        ]);
        /** @var Dir $dir */
        $dir = $this->make(Dir::class, [
            'findParentDir' => Expected::atLeastOnce('tests/_data/')
        ]);
        $this->testProcess = new DeployProcessApplication($commandProcessor, $dir);
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
