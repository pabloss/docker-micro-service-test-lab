<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface CommandListenerInterface
{
    public function push();
}
