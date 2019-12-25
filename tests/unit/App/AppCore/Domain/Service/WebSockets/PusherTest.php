<?php namespace App\AppCore\Domain\Service\WebSockets;

use Codeception\Stub\Expected;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Ratchet\Wamp\WampConnection;

class PusherTest extends \Codeception\Test\Unit
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
        $pusher = new Pusher();
        $pusher->onSubscribe($this->makeEmpty(ConnectionInterface::class), $this->make(Topic::class, ['getId' =>'test', 'broadcast' => $this->make(Topic::class)]));
        $pusher->onMsg(\json_encode(['topic' => 'test']));
        $pusher->onCall($this->make(WampConnection::class, ['callError' => $this->make(WampConnection::class, ['close' => Expected::atLeastOnce()])]),
            0,
            $this->make(Topic::class),
            []
            );

        $pusher->onPublish($this->make(WampConnection::class, ['close' => Expected::atLeastOnce()]), '', '', [], []);
    }
}
