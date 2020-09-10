<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

interface uServiceInterface
{
    public function getFile();
    public function getMovedToDir();
    public function unpacked();
    public function setMovedToDir(string $movedToDir);

    public function setUnpacked(string $unpackedLocation);
}
