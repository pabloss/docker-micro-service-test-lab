<?php
declare(strict_types=1);

namespace App\Framework\Service\Monitor\WebSockets\Context;

/**
 * Class WrappedContext
 * @package App\Framework\Service\Monitor\WebSockets
 */
class WrappedContext implements WrappedContextInterface
{
    /**
     * @var ContextInterface
     */
    private $context;

    /**
     * @var WrapperInterface
     */
    private $wrapper;

    /**
     * WrappedContext constructor.
     *
     * @param ContextInterface $context
     * @param WrapperInterface $wrapper
     */
    public function __construct(ContextInterface $context, WrapperInterface $wrapper)
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
