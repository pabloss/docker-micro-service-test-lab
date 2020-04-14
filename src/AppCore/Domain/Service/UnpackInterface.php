<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface UnpackInterface
{
    public function unpack(string $file, string $unpackedLocation);
}