<?php namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use Codeception\Stub;
use Codeception\Stub\Expected;
use DG\BypassFinals;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class SocketProgressBarOutputAdapterTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        BypassFinals::enable();
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {

        $consoleOutput = Stub::make(NullOutput::class, ['isDecorated' => false]);
        $progressBar = $this->construct(ProgressBar::class, ['output' => $consoleOutput], [
            'getMaxSteps' => 1
        ]);

        $adapter = new SocketProgressBarOutputAdapter(
            $this->make(WrappedContext::class, [
                'send' => Expected::atLeastOnce()
            ]),
            $progressBar
        );

        $adapter->writeln('', '');
        $adapter->writeln('', '');
        $adapter->writeln('', '');

        $adapter->writeln('', '');
        $adapter->writeln('', '');
    }
}