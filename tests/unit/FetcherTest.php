<?php

use App\AppCore\Domain\Service\Deploy\Command\WatcherInterface;
use App\Framework\Service\Monitor\Command\Fetcher\Fetcher;
use App\Framework\Service\Monitor\WebSockets\Context\WrappedContext;

class FetcherTest extends \Codeception\Test\Unit
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

        $wrappedContext = $this->prophesize(WrappedContext::class);
        $wrappedContext->send(['test'])->shouldBeCalled();

        $outputAdapter = $this->prophesize(WatcherInterface::class);
        $outputAdapter->willBeConstructedWith([$wrappedContext->reveal()]);
        $outputAdapter->writeln('test')->will(function ($args)use($wrappedContext){
            $wrappedContext->reveal()->send([$args[0]]);
        })->shouldBeCalled();


        $fetcher = new Fetcher();
        $fetcher->exec('echo -n test', $outputAdapter->reveal());
    }
}
