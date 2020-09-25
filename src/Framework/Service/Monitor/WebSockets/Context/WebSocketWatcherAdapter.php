<?php
declare(strict_types=1);

namespace App\Framework\Service\Monitor\WebSockets\Context;

use App\AppCore\Domain\Service\Deploy\Command\WatcherInterface;

class WebSocketWatcherAdapter extends WrappedContext implements WatcherInterface
{

    public function writeln(string $output)
    {
        $this->send(['log' => $output]);
    }
}
