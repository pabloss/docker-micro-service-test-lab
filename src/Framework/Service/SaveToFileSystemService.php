<?php
declare(strict_types=1);

namespace App\Framework\Service;

use App\AppCore\Application\Save\SaveToFileSystemInterface;
use App\AppCore\Domain\Actors\FileInterface;

class SaveToFileSystemService implements SaveToFileSystemInterface
{
    public function move(string $targetDir, FileInterface $domainUploadedFile): FileInterface
    {
        return $domainUploadedFile->move($targetDir);
    }
}
