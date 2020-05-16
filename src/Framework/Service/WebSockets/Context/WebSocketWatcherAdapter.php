<?php
declare(strict_types=1);

namespace App\Framework\Service\WebSockets\Context;

use App\AppCore\Domain\Service\Command\WatcherInterface;

class WebSocketWatcherAdapter extends WrappedContext implements WatcherInterface
{

    public function writeln(string $output)
    {
        $this->send([$output]);
    }
}
