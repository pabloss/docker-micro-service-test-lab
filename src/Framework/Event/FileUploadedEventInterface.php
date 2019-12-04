<?php
declare(strict_types=1);

namespace App\Framework\Event;

interface FileUploadedEventInterface
{
    public function getPhpFiles(): array;
}