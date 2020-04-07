<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Actors\FileInterface;

interface SaveApplicationInterface
{
    public function save(string $dir, FileInterface $file);
}
