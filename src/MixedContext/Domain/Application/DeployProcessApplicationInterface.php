<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application;

interface DeployProcessApplicationInterface
{
    public function run(string $targetDir);
}