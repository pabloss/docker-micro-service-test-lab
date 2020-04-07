<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

interface uServiceInterface
{
    public function file();
    public function movedToDir();
    public function setMovedToDir(string $movedToDir);
}
