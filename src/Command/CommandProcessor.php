<?php
declare(strict_types=1);

namespace App\Command;

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

    /** @var OutputAdapterInterface */
    private $outputAdapter;

    /**
     * CommandProcessor constructor.
     * @param OutputAdapterInterface $outputAdapter
     */
    public function __construct(OutputAdapterInterface $outputAdapter)
    {
        $this->outputAdapter = $outputAdapter;
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
            while ($s = fgets($pipes[self::STDOUT])) {
                $this->outputAdapter->writeln($s);
                flush();
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
}
