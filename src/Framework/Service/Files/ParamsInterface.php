<?php
declare(strict_types=1);

namespace App\Framework\Service\Files;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ParamsInterface
{
    public function getTargetDir(): string;
    public function getUploadedFile(): UploadedFile;
}