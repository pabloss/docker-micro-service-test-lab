<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Build\Unpack;

use App\AppCore\Domain\Actors\uServiceInterface;

interface UnpackServiceInterface
{
    public function unpack(uServiceInterface $service, string $unpackedLocation);
}
