<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Files;

class Dir
{
    /**
     * @param string $extractToDir
     * @return string
     */
    public function sureTargetDirExists(string  $extractToDir): string
    {
        if (false === \file_exists($extractToDir)) {
            \mkdir($extractToDir);
        }
        return $extractToDir;
    }
}
