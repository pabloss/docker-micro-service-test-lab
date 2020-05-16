<?php
declare(strict_types=1);

namespace App\Framework\Service\Command\Fetcher;

use App\AppCore\Application\Monitor\FetcherInterface;
use App\AppCore\Domain\Service\Command\OutPutInterface;

class Fetcher implements FetcherInterface
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


    public function exec(string $command, OutPutInterface $output)
    {
        flush();
        $process = \proc_open(
            $command,
            self::DESCRIPTOR_SPECS,
            $pipes,
            realpath('./'),
            []
        );
        if (is_resource($process)) {
            flush();
            while (($out = fgets($pipes[self::STDOUT])) !== FALSE) {
                    $output->writeln($out);
            }
            \fclose($pipes[self::STDOUT]);
        }
    }
}
