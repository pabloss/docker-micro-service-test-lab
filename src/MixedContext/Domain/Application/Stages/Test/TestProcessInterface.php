<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Test;

interface TestProcessInterface
{
    public function __invoke($payload);
    public function getTestCommandStr(string $testFilePath): string;
}