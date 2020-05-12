<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application;

interface TestProcessApplicationInterface
{
    public function run(string $targetDir);
}
