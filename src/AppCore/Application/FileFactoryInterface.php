<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Actors\FileInterface;

interface UploadedFileFactoryInterface
{
    public function createFile(string $file): FileInterface;
}
