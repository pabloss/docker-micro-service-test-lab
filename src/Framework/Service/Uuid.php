<?php
declare(strict_types=1);

namespace App\Framework\Service;

class Uuid
{
    /**
     * @param string $dirPath
     *
     * @return string
     */
    public function getUuidFromDir(string $dirPath): string
    {
        \preg_match('/(\w+)$/', $dirPath, $matches);
        if (\count($matches) < 2) {
            $matches = ['/'];
        }

        return $matches[0];
    }
}
