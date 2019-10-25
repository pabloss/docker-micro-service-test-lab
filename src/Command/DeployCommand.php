<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeployCommand extends Command
{
    protected static $defaultName = 'deploy';

    protected function configure()
    {
        $this->addArgument('run',InputArgument::REQUIRED, 'Docker command to run');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandProcessor = new CommandProcessor(new SymfonyCommandOutputAdapter($output));
        $commandProcessor->processRealTimeOutput($this->getCommandStr($input));
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    protected function getCommandStr(InputInterface $input): string
    {
        return
            "docker run {$input->getArgument("run")}" .
            " " .
            CommandProcessor::getBashOutRedirect(CommandProcessor::STDERR, CommandProcessor::STDOUT);
    }
}
