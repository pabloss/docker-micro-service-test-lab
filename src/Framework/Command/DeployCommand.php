<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeployCommand extends Command
{
    protected static $defaultName = 'deploy';

    protected function configure()
    {
        $this->addArgument('tag', InputArgument::REQUIRED, 'Docker image tag');
        $this->addArgument('in-port', InputArgument::REQUIRED, 'Docker internal port number');
        $this->addArgument('out-port', InputArgument::REQUIRED, 'Docker external port number');
        $this->addArgument('container-name', InputArgument::REQUIRED, 'Docker container name');
        $this->addArgument('dockerfile', InputArgument::REQUIRED, 'Dockerfile path');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandProcessor = new CommandProcessor(new SymfonyCommandOutputAdapter($output));
        $commandProcessor->processRealTimeOutput($this->getBuildCommandStr($input));
        $commandProcessor->processRealTimeOutput($this->getRunCommandStr($input));
    }

    /**
     * @param InputInterface $input
     * @return string
     */
    protected function getBuildCommandStr(InputInterface $input): string
    {
        return
            "docker image build -t {$input->getArgument("tag")} {$input->getArgument("dockerfile")}" .
            " " .
            CommandProcessor::getBashOutRedirect(CommandProcessor::STDERR, CommandProcessor::STDOUT);
    }
    /**
     * @param InputInterface $input
     * @return string
     */
    protected function getRunCommandStr(InputInterface $input): string
    {
        // docker image build -t {tag} .
        // docker container run --publish {out_port}:{in_port} --detach --name {container_name} {tag}
        return
            "docker container run --publish {$input->getArgument("out-port")}:{$input->getArgument("in-port")} --detach --name {$input->getArgument("container-name")} {$input->getArgument("tag")}" .
            " " .
            CommandProcessor::getBashOutRedirect(CommandProcessor::STDERR, CommandProcessor::STDOUT);
    }
}
