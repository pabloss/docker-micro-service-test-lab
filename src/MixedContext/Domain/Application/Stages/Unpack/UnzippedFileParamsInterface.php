<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Application\Stages\Unpack;

interface UnzippedFileParamsInterface
{
    public function getTargetDir(): string;
    public function getTargetFile(): string;
    function toArray(): array;
}