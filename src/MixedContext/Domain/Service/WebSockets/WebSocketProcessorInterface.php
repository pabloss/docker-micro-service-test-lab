<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\WebSockets;

interface WebSocketProcessorInterface
{
    public function run();

}