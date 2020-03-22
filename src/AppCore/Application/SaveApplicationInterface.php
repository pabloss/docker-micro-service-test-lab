<?php
declare(strict_types=1);

namespace App\AppCore\Application;

interface SaveApplicationInterface
{
    public function save(string $dir, string $file);
}
