<?php
declare(strict_types=1);

namespace App\AppCore\Application\Save;

use App\AppCore\Domain\Actors\FileInterface;

interface SaveApplicationInterface
{
    public function save(string $dir, FileInterface $file, \DateTime $when);
}
