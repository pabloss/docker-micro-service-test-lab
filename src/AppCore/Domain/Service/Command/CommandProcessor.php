<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

class CommandProcessor
{
    // the name of the command (the part after "bin/console")
    const STDIN = 0;
    const STDOUT = 1;
    const STDERR = 2;

    const DESCRIPTOR_SPECS = [
        self::STDIN => ["pipe", "r"],   // stdin is a pipe that the child will read from
        self::STDOUT => ["pipe", "w"],   // stdout is a pipe that the child will write to
        self::STDERR => ["pipe", "w"]    // stderr is a pipe that the child will write to
    ];

    /**
     * @var FetchOutInterface
     */
    private $fetchOut;

    /**
     * CommandProcessor constructor.
     * @param FetchOutInterface $fetchOut
     */
    public function __construct(FetchOutInterface $fetchOut)
    {
        $this->fetchOut = $fetchOut;
    }

    public function processRealTimeOutput(string $command)
    {
        flush();
        $process = proc_open(
            $command,
            self::DESCRIPTOR_SPECS,
            $pipes,
            realpath('./'),
            []
        );
        if (is_resource($process)) {
            while ($this->fetchOut->fetchedOut($pipes)) {
                \sleep(1);
            }
        }
    }
}
