<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface CommandInterface
{
    public function command():string;
}
