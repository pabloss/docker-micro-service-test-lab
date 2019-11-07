<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\AppCore\Domain\Service\Command\OutputAdapterInterface;
use App\AppCore\Domain\Service\Context;

class SocketOutputAdapter implements OutputAdapterInterface
{
    const MSG = 'msg';
    /**
     * @var Context
     */
    private $context;

    /**
     * SocketOutputAdapter constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param string $message
     * @throws \ZMQSocketException
     */
    public function writeln(string $message)
    {
        $entryData = [];
        $entryData[self::MSG] = 'message';
        $entryData['log'] = $message;
        $this->context->send($entryData);
    }
}
