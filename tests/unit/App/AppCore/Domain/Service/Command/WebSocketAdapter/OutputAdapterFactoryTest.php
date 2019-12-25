<?php namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Command\WebSocketAdapter\Exception\WrongStdException;

class OutputAdapterFactoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var OutputAdapterFactory */
    private $factory;
    
    protected function _before()
    {

    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $socketProgressBarOutputAdapter = $this->make(SocketProgressBarOutputAdapter::class);
        $socketErrorOutputAdapter = $this->make(SocketErrorOutputAdapter::class);
        $factory = new OutputAdapterFactory(
            $socketProgressBarOutputAdapter,
            $socketErrorOutputAdapter,
        );


        self::assertSame($socketProgressBarOutputAdapter, $factory->getByOut(CommandProcessor::STDOUT));
        self::assertSame($socketErrorOutputAdapter, $factory->getByOut(CommandProcessor::STDERR));
    }
    // tests
    public function testException()
    {
        self::expectException(WrongStdException::class);
        $socketProgressBarOutputAdapter = $this->make(SocketProgressBarOutputAdapter::class);
        $socketErrorOutputAdapter = $this->make(SocketErrorOutputAdapter::class);
        $factory = new OutputAdapterFactory(
            $socketProgressBarOutputAdapter,
            $socketErrorOutputAdapter,
        );


        $factory->getByOut(3);
    }

}
