<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;

use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use Symfony\Component\Console\Helper\ProgressBar;

class SocketProgressBarOutputAdapter implements OutputAdapterInterface
{
    const LOG_KEY = 'log';
    const PROGRESS_KEY = 'progress';
    const MAX_PROGRESS_KEY = 'max';
    const DIR_KEY = 'index';

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
     * @param string $dir
     * @throws \ZMQSocketException
     */
    public function writeln(string $message, string $dir)
    {
        $this->calculateProgress();
        $this->context->send($this->createEntry($message, $dir));
    }

    /**
     * @param string $message
     * @param string $dir
     * @return array
     */
    private function createEntry(string $message, string $dir): array
    {
        return [
            self::LOG_KEY =>            $message,
            self::PROGRESS_KEY =>       $this->progressBar->getProgress(),
            self::MAX_PROGRESS_KEY =>   $this->progressBar->getMaxSteps(),
            self::DIR_KEY => $dir
        ];
    }

    private function calculateProgress(): void
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
