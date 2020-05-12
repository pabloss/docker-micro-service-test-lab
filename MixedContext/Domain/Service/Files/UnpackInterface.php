<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Service\Files;

interface UnpackInterface
{
    public function unzip(string $zipFilePath, string $dirName);
    public function getTargetDir(string $parentDir, string $filePath): string;
}
