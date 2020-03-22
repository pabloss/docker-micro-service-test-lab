<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Actors\UploadedFileInterface;

interface UploadedFileFactoryInterface
{
    public function createUploadedFile(string $file): UploadedFileInterface;
}
