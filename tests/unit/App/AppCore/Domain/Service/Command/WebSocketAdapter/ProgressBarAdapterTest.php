<?php namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;
use Codeception\Stub\Expected;
use DG\BypassFinals;
use Symfony\Component\Console\Helper\ProgressBar;

class ProgressBarAdapterTest extends \Codeception\Test\Unit
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
        $adapter = new ProgressBarAdapter(
            $this->make(ProgressBar::class, [
                'getProgress' => 1,
                'getMaxSteps' => 3,
                'start' => Expected::atLeastOnce(),
                'advance' => Expected::atLeastOnce(),
                'setMaxSteps' => Expected::atLeastOnce(),
            ])
        );

        $adapter->start();
        $adapter->advance();
        $adapter->setMaxSteps(4);
        $this->assertEquals(1, $adapter->getProgress());
        $this->assertEquals(3, $adapter->getMaxSteps());
    }
}
