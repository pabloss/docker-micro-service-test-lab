<?php
declare(strict_types=1);

namespace App\Framework\Files;

interface UnpackInterface
{
    public function unzip(string $zipFilePath, string $dirName);
    public function getTargetDir(string $parentDir, string $filePath): string;
}
