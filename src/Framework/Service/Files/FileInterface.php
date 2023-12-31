<?php
declare(strict_types=1);

namespace App\Framework\Service\Files;

interface FileInterface
{
    public function getBasenameWithoutExtension(string $filePath): string;
    public function getExtension(string $filePath);
    public function isMimeTypeOf(string $mimeType, string $file): bool;
}
