<?php namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use App\AppCore\Domain\Service\WebSockets\WrappedContextInterface;
use Codeception\Stub\Expected;

class SocketErrorOutputAdapterTest extends \Codeception\Test\Unit
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
        $adapter = new SocketErrorOutputAdapter(
            $this->make(WrappedContext::class, [
                'send' => Expected::atLeastOnce()
            ])
        );

        $adapter->writeln('', '');
    }
}
