<?php
declare(strict_types=1);

namespace App\Command;

interface OutputAdapterInterface
{
    public function writeln(string $message);
}
