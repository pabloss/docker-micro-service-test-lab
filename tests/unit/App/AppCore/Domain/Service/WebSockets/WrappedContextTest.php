<?php namespace App\Framework\Service\Monitor\WebSockets;

use App\Framework\Service\Monitor\WebSockets\Context\Context;
use App\Framework\Service\Monitor\WebSockets\Context\WrappedContext;
use App\Framework\Service\Monitor\WebSockets\Context\Wrapper;
use Codeception\Stub\Expected;

class WrappedContextTest extends \Codeception\Test\Unit
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
        $context = new WrappedContext(
            $this->make(Context::class, ['send' => Expected::atLeastOnce()]),
            $this->make(Wrapper::class, ['wrap' => []])
        );

        $context->send([]);
    }
}
