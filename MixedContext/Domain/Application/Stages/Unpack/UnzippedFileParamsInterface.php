<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Application\Stages\Unpack;

interface UnzippedFileParamsInterface
{
    public function getTargetDir(): string;
    public function getTargetFile(): string;
    function toArray(): array;
}
