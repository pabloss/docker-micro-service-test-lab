<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\CommandProcessor;

class OutputAdapterFactory implements OutputAdapterFactoryInterface
{
    /**
     * @var SocketProgressBarOutputAdapter
     */
    private $socketProgressBarOutputAdapter;

    /**
     * @var SocketErrorOutputAdapter
     */
    private $socketErrorOutputAdapter;

    /**
     * OutPutFactory constructor.
     * @param SocketProgressBarOutputAdapter $socketProgressBarOutputAdapter
     * @param SocketErrorOutputAdapter $socketErrorOutputAdapter
     */
    public function __construct(
        SocketProgressBarOutputAdapter $socketProgressBarOutputAdapter,
        SocketErrorOutputAdapter $socketErrorOutputAdapter
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
