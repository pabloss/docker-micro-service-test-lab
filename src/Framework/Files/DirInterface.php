<?php
declare(strict_types=1);

namespace App\Framework\Files;

interface DirInterface
{

    public function sureTargetDirExists(string  $extractToDir): string;
    public function findFile(string $dir, string $fileToFind);
    public function findParentDir(string $dir, string $fileToFind);
}