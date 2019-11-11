<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\WebSockets;

use App\AppCore\Domain\Service\WebSockets\Context\Context;
use App\AppCore\Domain\Service\WebSockets\Context\Wrapper;

/**
 * Class WrappedContext
 * @package App\AppCore\Domain\Service\WebSockets
 */
class WrappedContext
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var Wrapper
     */
    private $wrapper;

    /**
     * WrappedContext constructor.
     * @param Context $context
     * @param Wrapper $wrapper
     */
    public function __construct(Context $context, Wrapper $wrapper)
    {
        $this->context = $context;
        $this->wrapper = $wrapper;
    }

    /**
     * @param array $entryData
     * @throws \ZMQSocketException
     */
    public function send(array $entryData)
    {
        $this->context->send($this->wrapper->wrap($entryData));
    }
}
