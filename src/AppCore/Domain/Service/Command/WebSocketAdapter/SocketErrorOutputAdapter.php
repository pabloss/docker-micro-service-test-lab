<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\WebSockets\WrappedContext;

class SocketErrorOutputAdapter extends AbstractSocketOutputAdapter
{
    const ERROR_KEY = 'error';

    /**
     * @var WrappedContext
     */
    protected $context;

    /**
     * SocketErrorOutputAdapter constructor.
     * @param WrappedContext $context
     */
    public function __construct(WrappedContext $context)
    {
        $this->context = $context;
    }

    /**
     * @param $pipes
     * @return bool
     * @throws \ZMQSocketException
     */
    public function fetchedOut($pipes): bool
    {
        return parent::fetchedOut( fgets($pipes[CommandProcessor::STDERR]));
    }

    /**
     * @param string $message
     * @return array
     */
    protected function createEntry(string $message): array
    {
        $entryData = [];
        $entryData[self::ERROR_KEY] = $message;
        return $entryData;
    }
}
