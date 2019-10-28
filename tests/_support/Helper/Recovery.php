<?php
declare(strict_types=1);

namespace App\Tests\_support\Helper;

trait Recovery
{

    /**
     * @var string
     */
    private $dockerImage;

    /**
     * @var string
     */
    private $dockerSearch;

    public function __construct()
    {
        $this->dockerImage = 'bulletinboard:1.0';
        $this->dockerSearch = "docker ps -a | grep '" . $this->dockerImage . "' | awk '{print $1}'";
    }

    public function dir(string $dirName)
    {
        $this->cleanDir($dirName);
        mkdir($dirName);
        exec("chmod 777 " . $dirName . " -R");
        file_put_contents($dirName . ".gitkeep", "");
    }

    public function docker(): void
    {

        \exec("docker stop $(" . $this->dockerSearch . ")");
        \exec("docker rm $(" . $this->dockerSearch . ")");
        \exec("docker rmi " . $this->dockerImage);
    }

    private function cleanDir($dirname)
    {
        $dir_handle = false;
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    $this->cleanDir($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
}
