<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Deploy;

interface RunProcessInterface
{
    public function __invoke($payload);
    public function getRunCommandStr(string $containerName, string $tag): string;

}