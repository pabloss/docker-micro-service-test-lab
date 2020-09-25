<?php
declare(strict_types=1);

namespace App\Framework\Service\Monitor\WebSockets\Context;

interface WrapperInterface
{
    public function wrap(array $entryData);
}
