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
     * @var OutputAdapterInterface
     */
    private $stdOutOutputAdapter;

    /**
     * @var OutputAdapterInterface
     */
    private $stdErrOutputAdapter;

    /**
     * CommandProcessor constructor.
     * @param OutputAdapterInterface $stdOutOutputAdapter
     * @param OutputAdapterInterface $stdErrOutputAdapter
     */
    public function __construct(
        OutputAdapterInterface $stdOutOutputAdapter,
        OutputAdapterInterface $stdErrOutputAdapter
    ) {
        $this->stdOutOutputAdapter = $stdOutOutputAdapter;
        $this->stdErrOutputAdapter = $stdErrOutputAdapter;
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
            while (
                $this->stdOutOutputAdapter->fetchedOut($pipes) ||
                $this->stdErrOutputAdapter->fetchedOut($pipes)
            ) {
                \sleep(1);
            }
        }
    }

    /**
     * @param int $from
     * @param int $to
     * @return string
     */
    public static function getBashOutRedirect(int $from, int $to): string
    {
        return "$from>&$to";
    }

    /**
     * @param $pipes
     * @return false|string
     */
    private function fetchStdOut($pipes)
    {
        return fgets($pipes[self::STDOUT]);
    }

    /**
     * @param $pipes
     * @return false|string
     */
    private function fetchStdErr($pipes)
    {
        return fgets($pipes[self::STDERR]);
    }
}
