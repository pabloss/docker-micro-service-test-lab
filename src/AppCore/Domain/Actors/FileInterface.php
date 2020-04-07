<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

interface FileInterface
{
    public function getBasename(): string ;
    public function getPath(): string ;
    public function move(string $dir): self;
}
