<?php
declare(strict_types=1);

namespace App\Framework\Service\WebSockets\Context;

use App\AppCore\Domain\Service\Command\OutPutInterface;

class WrappedContextSendAdapter extends WrappedContext implements OutPutInterface
{

    public function writeln(string $output)
    {
        $this->send([$output]);
    }
}
