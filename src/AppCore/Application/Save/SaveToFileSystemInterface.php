<?php
declare(strict_types=1);

namespace App\AppCore\Application\Save;

use App\AppCore\Domain\Actors\FileInterface;

interface SaveToFileSystemInterface
{
    public function move(string $targetDir, FileInterface $domainUploadedFile, \DateTime $when): FileInterface;
}
