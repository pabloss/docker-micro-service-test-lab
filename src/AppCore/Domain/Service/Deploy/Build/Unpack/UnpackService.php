<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Deploy\Build\Unpack;

use App\AppCore\Domain\Actors\uServiceInterface;

class UnpackService implements UnpackServiceInterface
{
    /**
     * @var UnpackInterface
     */
    private $unpack;

    /**
     * UnpackService constructor.
     *
     * @param UnpackInterface $unpack
     */
    public function __construct(UnpackInterface $unpack)
    {
        $this->unpack = $unpack;
    }


    public function unpack(uServiceInterface $service, string $unpackedLocation)
    {
        $this->unpack->unpack($service->getFile(), $unpackedLocation);
        $service->setUnpacked($unpackedLocation);
        return $service;
    }
}
