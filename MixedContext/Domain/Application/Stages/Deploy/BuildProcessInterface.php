<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application\Stages\Deploy;

interface BuildProcessInterface
{
    public function __invoke($payload);
    public function getBuildCommandStr(string $tag, string $dockerFile): string;
}
