<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SymfonyCommandOutputAdapter implements OutputAdapterInterface
{
    /** @var OutputInterface */
    private $output;

    /**
     * SymfonyCommandOutput constructor.
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function writeln(string $message)
    {
        $this->output->writeln($message);
    }

}
