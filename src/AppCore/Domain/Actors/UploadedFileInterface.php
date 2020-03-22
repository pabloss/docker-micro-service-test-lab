<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

interface UploadedFileInterface
{
    public function getBasename(): string ;
}
