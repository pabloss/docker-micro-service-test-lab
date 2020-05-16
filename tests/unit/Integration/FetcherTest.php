<?php namespace Integration;

use App\Framework\Service\Command\Fetcher\Fetcher;
use App\Framework\Service\WebSockets\Context\Context;
use App\Framework\Service\WebSockets\Context\WrappedContextSendAdapter;
use App\Framework\Service\WebSockets\Context\Wrapper;
use App\Tests\unit\Integration\Stubs\OutPutAdapter;
use Codeception\Util\Autoload;


class FetcherTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        Autoload::addNamespace('Integration\Stubs', __DIR__.'/Stubs/');
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $fetcher = new Fetcher();

        $outputAdapterStub = new OutPutAdapter();
        $fetcher->exec('echo -n test', $outputAdapterStub);
        $out = $outputAdapterStub->getOuts();
        $this->tester->assertEquals('test', $out);
    }

    // tests
    public function testSomeFeature1()
    {
        $fetcher = new Fetcher();

        $outputAdapterStub = new WrappedContextSendAdapter(new Context(new \ZMQContext(), '127.0.0.1', 5555), new Wrapper());
        $fetcher->exec('echo -n test', $outputAdapterStub);
    }
}
