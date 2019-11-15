<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use App\AppCore\Domain\Service\WebSockets\WrappedContext;

abstract class AbstractSocketOutputAdapter implements OutputAdapterInterface
{
    /**
     * @var WrappedContext
     */
    protected $context;

    /**
     * @param string $message
     * @throws \ZMQSocketException
     */
    public function writeln(string $message)
    {
        $this->context->send($this->createEntry($message));
    }

    /**
     * @param $out
     * @return bool
     * @throws \ZMQSocketException
     */
    public function fetchedOut($out): bool
    {
        flush();
        if(isset($out) && \is_string($out)){
            $this->writeln($out);
            return true;
        }
        return false;
    }

    protected abstract function createEntry(string $message): array;
}
