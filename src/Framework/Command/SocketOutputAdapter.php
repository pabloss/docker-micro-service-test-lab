<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use App\AppCore\Domain\Service\WebSockets\Context\Context;
use App\AppCore\Domain\Service\WebSockets\Context\Wrapper;

class SocketOutputAdapter implements OutputAdapterInterface
{
    /**
     * @var \App\AppCore\Domain\Service\WebSockets\Context
     */
    private $context;

    /**
     * @var Wrapper
     */
    private $wrapper;

    /**
     * SocketOutputAdapter constructor.
     * @param Context $context
     * @param \App\AppCore\Domain\Service\WebSockets\Context\Wrapper $wrapper
     */
    public function __construct(Context $context, Wrapper $wrapper)
    {
        $this->context = $context;
        $this->wrapper = $wrapper;
    }

    /**
     * @param string $message
     * @throws \ZMQSocketException
     */
    public function writeln(string $message)
    {
        $entryData['log'] = $message;
        $this->context->send($this->wrapper->wrap($entryData));
    }
}
