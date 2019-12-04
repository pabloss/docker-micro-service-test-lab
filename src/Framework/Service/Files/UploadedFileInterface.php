<?php
declare(strict_types=1);

namespace App\Framework\Service\Files;

use Symfony\Component\HttpFoundation\File\File;
interface UploadedFileInterface
{
    public function getUniqueFileName(): string;
    public function move($directory, $name = null): File;
    public function getTargetFile(): string;
}