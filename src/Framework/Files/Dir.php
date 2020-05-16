<?php
declare(strict_types=1);

namespace App\Framework\Files;

class Dir implements DirInterface
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

    public function findFile(string $dir, string $fileToFind)
    {
            $tree = glob(rtrim($dir, '/') . '/*');
            if (is_array($tree)) {
                foreach($tree as $file) {
                    if (is_dir($file)) {
//                        if(in_array($fileToFind, scandir($file))){
//                            return $file . '/'. $fileToFind;
//                        }
                        return $this->findFile($file, $fileToFind);
                    } elseif (is_file($file) && $fileToFind === \basename($file)) {
                        return $file;
                    }
                }
            }
    }

    public function findParentDir(string $dir, string $fileToFind)
    {
        return \dirname($this->findFile($dir, $fileToFind));
    }
}
