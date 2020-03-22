<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use phpDocumentor\Reflection\Types\Context;
use Symfony\Component\Console\Helper\ProgressBar;

class ProgressBarAdapter
{
    /**
     * @var ProgressBar
     */
    private $progressBar;

    public function __construct(ProgressBar $progressBar)
    {
        $this->progressBar = $progressBar;
    }

    public function start()
    {
        $this->progressBar->start();
    }

    public function advance()
    {
        $this->progressBar->advance();
    }

    public function getProgress()
    {
        return $this->progressBar->getProgress();
    }

    public function getMaxSteps()
    {
        return $this->progressBar->getMaxSteps();
    }

    public function setMaxSteps(int $maxSteps)
    {
        $this->progressBar->setMaxSteps($maxSteps);
    }
}
