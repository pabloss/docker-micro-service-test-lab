<?php namespace App\AppCore\Domain\Service\Command;

use App\AppCore\Domain\Service\Command\WebSocketAdapter\OutputAdapterFactory;
use Codeception\Stub;

class CommandProcessorTest extends \Codeception\Test\Unit
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
        $processor = new CommandProcessor($this->make(OutputAdapterFactory::class, ['getByOut' => Stub::makeEmpty(OutputAdapterInterface::class)]));
        $processor->processRealTimeOutput('echo', '');
    }
}
