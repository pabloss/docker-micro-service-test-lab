<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application;

interface TestProcessApplicationInterface
{
    public function run(string $targetDir);
}