<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use App\AppCore\Domain\Service\WebSockets\Context\Context;
use App\AppCore\Domain\Service\WebSockets\Context\Wrapper;
use App\AppCore\Domain\Service\WebSockets\WrappedContext;
use Symfony\Component\Console\Helper\ProgressBar;

class SocketProgressBarOutputAdapter  implements OutputAdapterInterface
{
    const LOG_KEY = 'log';
    const PROGRESS_KEY = 'progress';
    const MAX_PROGRESS_KEY = 'max';

    /**
     * @var WrappedContext
     */
    private $context;

    /**
     * @var int
     */
    private $counter = 0;

    /**
     * @var ProgressBar
     */
    private $progressBar;

    /**
     * @var Wrapper
     */
    private $wrapper;

    /**
     * SocketProgressBarOutputAdapter constructor.
     * @param WrappedContext $context
     * @param ProgressBar $progressBar
     * @param Wrapper $wrapper
     */
    public function __construct(WrappedContext $context, ProgressBar $progressBar, Wrapper $wrapper)
    {
        $this->context = $context;
        $this->progressBar = $progressBar;
        $this->wrapper = $wrapper;
    }


    /**
     * @param string $message
     * @throws \ZMQSocketException
     */
    public function writeln(string $message)
    {
        $this->moveProgress();
        $this->context->send($this->createEntry($message));
    }

    /**
     * @param string $message
     * @return array
     */
    private function createEntry(string $message): array
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
            $this->progressBar->setMaxSteps(2*$this->progressBar->getMaxSteps());
        }
        $this->progressBar->advance();
        $this->counter++;
    }
}
