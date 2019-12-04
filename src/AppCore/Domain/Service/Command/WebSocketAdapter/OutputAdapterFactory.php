<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Command\OutputAdapterInterface;

class OutputAdapterFactory implements OutputAdapterFactoryInterface
{
    /**
     * @var OutputAdapterInterface
     */
    private $socketProgressBarOutputAdapter;

    /**
     * @var OutputAdapterInterface
     */
    private $socketErrorOutputAdapter;

    /**
     * OutPutFactory constructor.
     *
     * @param OutputAdapterInterface $socketProgressBarOutputAdapter
     * @param OutputAdapterInterface $socketErrorOutputAdapter
     */
    public function __construct(
        OutputAdapterInterface  $socketProgressBarOutputAdapter,
        OutputAdapterInterface $socketErrorOutputAdapter
    ) {
        $this->socketProgressBarOutputAdapter = $socketProgressBarOutputAdapter;
        $this->socketErrorOutputAdapter = $socketErrorOutputAdapter;
    }


    public function getByOut(int $out)
    {
        switch ($out)
        {
            case CommandProcessor::STDOUT:
                return $this->socketProgressBarOutputAdapter;
                break;
            case CommandProcessor::STDERR:
                return $this->socketErrorOutputAdapter;
                break;
        }

    }
}
