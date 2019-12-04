<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

use App\AppCore\Domain\Service\Command\WebSocketAdapter\OutputAdapterFactory;

class CommandProcessor implements CommandProcessorInterface
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
     * @var OutputAdapterFactory
     */
    private $factory;

    /**
     * CommandProcessor constructor.
     * @param OutputAdapterFactory $factory
     */
    public function __construct(OutputAdapterFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $command
     * @param string $dir
     * @throws \ZMQSocketException
     */
    public function processRealTimeOutput(string $command, string $dir)
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
                $this->fetchedOut($pipes, self::STDOUT, $dir) ||
                $this->fetchedOut($pipes, self::STDERR, $dir)
            ) {
                \sleep(1);
            }
        }
    }

    /**
     * @param $pipes
     * @param int $stdCode
     * @param string $dir
     * @return bool
     * @throws \ZMQSocketException
     */
    public function fetchedOut($pipes, int $stdCode, string $dir): bool
    {
        $out = fgets($pipes[$stdCode]);
        flush();
        if(isset($out) && \is_string($out)){
            $this->factory->getByOut($stdCode)->writeln($out, $dir);
            return true;
        }
        return false;
    }
}
