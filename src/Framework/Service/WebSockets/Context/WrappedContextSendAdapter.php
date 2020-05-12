<?php
declare(strict_types=1);

namespace App\Framework\Command;

use App\AppCore\Domain\Service\OutPutInterface;
use App\Framework\Service\WebSockets\WrappedContext;

class WrappedContextSendAdapter extends WrappedContext implements OutPutInterface
{

    public function writeln(string $output)
    {
        $this->send([$output]);
    }
}
