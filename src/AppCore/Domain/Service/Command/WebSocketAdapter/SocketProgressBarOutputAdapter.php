<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use Symfony\Component\Console\Helper\ProgressBar;

class SocketProgressBarOutputAdapter extends AbstractSocketOutputAdapter
{
    const LOG_KEY = 'log';
    const PROGRESS_KEY = 'progress';
    const MAX_PROGRESS_KEY = 'max';

    /**
     * @var WrappedContext
     */
    protected $context;

    /**
     * @var int
     */
    private $counter = 0;

    /**
     * @var ProgressBar
     */
    private $progressBar;

    /**
     * SocketProgressBarOutputAdapter constructor.
     * @param WrappedContext $context
     * @param ProgressBar $progressBar
     */
    public function __construct(WrappedContext $context, ProgressBar $progressBar)
    {
        $this->context = $context;
        $this->progressBar = $progressBar;
    }

    /**
     * @param string $message
     * @throws \ZMQSocketException
     */
    public function writeln(string $message)
    {
        $this->moveProgress();
        parent::writeln($message);
    }

    /**
     * @param $pipes
     * @return bool
     * @throws \ZMQSocketException
     */
    public function fetchedOut($pipes): bool
    {
        return parent::fetchedOut(fgets($pipes[CommandProcessor::STDOUT]));
    }

    /**
     * @param string $message
     * @return array
     */
    protected function createEntry(string $message): array
    {
        $entryData = [];
        $entryData[self::LOG_KEY] = $message;
        $entryData[self::PROGRESS_KEY] = $this->progressBar->getProgress();
        $entryData[self::MAX_PROGRESS_KEY] = $this->progressBar->getMaxSteps();
        return $entryData;
    }

    private function moveProgress(): void
    {
        if ($this->counter === 0) {
            $this->progressBar->start();
        } elseif ($this->counter > $this->progressBar->getMaxSteps()) {
            $this->progressBar->setMaxSteps(2 * $this->progressBar->getMaxSteps());
        }
        $this->progressBar->advance();
        $this->counter++;
    }
}
