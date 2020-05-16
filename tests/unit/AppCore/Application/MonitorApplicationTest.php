<?php namespace AppCore\Application;

use App\AppCore\Domain\Service\CommandInterface;
use App\AppCore\Domain\Service\CommandRunnerInterface;
use App\AppCore\Domain\Service\CommandsCollectionInterface;
use App\AppCore\Domain\Service\PusherInterface;
use App\AppCore\Application\MonitorApplication;

class MonitorApplicationTest extends \Codeception\Test\Unit
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
        /**
         * Jeśli runner dostanie comendy
         * to listener odbierze output
         *      przekaże go do pushera
         * pusher wysyła do websocketa
         *
         *
         * Jak to realizować w teście?
         *
         * Runner w teście unitowym ma jedynie uruchamiać komendę
         *   - docelowo będzie wysyłał eventy , bo output to nie wartość zwracana
         * Listener dostanie eventy z payoloadem
         * i użyje pushera: listener przekaże output do pushera: push('out', outType)
         */
        $outType = 'stoOut';
        $testText = "TEST IT!";
        $testCommand = $this->prophesize(CommandInterface::class);
        $testCommand->command()->willReturn("echo $testText")->shouldBeCalled();

        $collection = $this->prophesize(CommandsCollectionInterface::class);
        $collection->addCommand($testCommand->reveal())->shouldBeCalled();
        $collection->getCommand(0)->willReturn($testCommand->reveal())->shouldBeCalled();

        $pusher = $this->prophesize(PusherInterface::class);
        $pusher->send([
            'out' => $testText,
            'outType' => $outType,
        ])->shouldBeCalled();
        $runner  = $this->prophesize(CommandRunnerInterface::class);
        $runner->run($collection->reveal())->shouldBeCalled();
        $runner->run($collection->reveal())->will(function ($args) use ($pusher, $testText) {
            $outType = 'stoOut';
            $args[0]->getCommand(0)->command();
            $pusher->reveal()->send([
                'out' => $testText,
                'outType' => $outType,
            ]);
        });

        $collection->reveal()->addCommand($testCommand->reveal());
        $application = new MonitorApplication($runner->reveal());

        $application->run($collection->reveal());
    }
}
