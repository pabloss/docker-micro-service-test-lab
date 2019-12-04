<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\WebSockets;

use App\AppCore\Domain\Service\WebSockets\Context\Context;
use App\AppCore\Domain\Service\WebSockets\Context\ContextInterface;
use App\AppCore\Domain\Service\WebSockets\Context\Wrapper;
use App\AppCore\Domain\Service\WebSockets\Context\WrapperInterface;

/**
 * Class WrappedContext
 * @package App\AppCore\Domain\Service\WebSockets
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
