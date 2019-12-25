<?php namespace App\AppCore\Domain\Service\WebSockets;

use App\AppCore\Domain\Service\WebSockets\Context\Context;
use App\AppCore\Domain\Service\WebSockets\Context\Wrapper;
use App\AppCore\Domain\Service\WebSockets\Context\WrapperInterface;
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
