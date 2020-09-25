<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Build\Unpack;

interface UnpackInterface
{
    public function unpack(string $file, string $unpackedLocation);
}
