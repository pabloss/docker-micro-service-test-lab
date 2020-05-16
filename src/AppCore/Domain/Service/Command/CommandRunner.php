<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

use App\AppCore\Application\Monitor\FetcherInterface;

class CommandRunner implements CommandRunnerInterface
{
    /**
     * @var \App\AppCore\Application\Monitor\FetcherInterface
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
