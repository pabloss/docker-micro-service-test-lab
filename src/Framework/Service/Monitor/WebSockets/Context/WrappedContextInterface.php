<?php
declare(strict_types=1);

namespace App\Framework\Service\Monitor\WebSockets\Context;

interface WrappedContextInterface
{
    public function send(array $entryData);

}
