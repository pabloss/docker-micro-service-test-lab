<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application\Stages\Deploy;

interface UpProcessInterface
{
    public function __invoke($payload);
    public function getUpCommandStr(string $confFile): string;
}
