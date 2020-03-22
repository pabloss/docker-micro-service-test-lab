<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\WebSockets;

use Ratchet\ConnectionInterface;

interface PusherInterface
{
    public function onSubscribe(ConnectionInterface $conn, $topic);
    public function onMsg($entry);
}