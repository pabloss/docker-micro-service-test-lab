<?php
declare(strict_types=1);

namespace App\Framework\Files;

class File implements FileInterface
{
    /**
     * @param string $filePath
     * @return string
     */
    public function getBasenameWithoutExtension(string $filePath): string
    {
        return \basename($filePath, '.' . $this->getExtension($filePath));
    }

    /**
     * @param string $filePath
     * @return mixed
     */
    public function getExtension(string $filePath)
    {
        return \pathinfo($filePath)['extension'];
    }

    public function isMimeTypeOf(string $mimeType, string $file): bool
    {
        return $mimeType === mime_content_type($file);
    }
}
