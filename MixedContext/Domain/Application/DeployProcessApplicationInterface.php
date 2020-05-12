<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application;

interface DeployProcessApplicationInterface
{
    public function run(string $targetDir);
}
