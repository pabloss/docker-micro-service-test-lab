<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command;

interface OutPutInterface
{
    public function writeln(string $output);
}
