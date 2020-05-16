<?php
declare(strict_types=1);

namespace App\Framework\Service\Command;

use App\AppCore\Domain\Service\CommandRunnerInterface;
use App\AppCore\Domain\Service\CommandsCollectionInterface;
use App\AppCore\Domain\Service\OutPutInterface;
use App\Framework\Service\Command\Fetcher\FetcherInterface;

class CommandRunner implements CommandRunnerInterface
{
    /**
     * @var \App\Framework\Service\Command\Fetcher\FetcherInterface
     */
    private $fetcher;
    /**
     * @var OutPutInterface
     */
    private $outPut;

    public function __construct(FetcherInterface $fetcher, OutPutInterface $outPut)
    {
        $this->fetcher = $fetcher;
        $this->outPut = $outPut;
    }

    public function run(CommandsCollectionInterface $commandsCollection)
    {
        for($i = 0; $i < $commandsCollection->count(); $i++){
            $this->fetcher->exec($commandsCollection->getCommand($i)->command(), $this->outPut);
        }
    }
}
