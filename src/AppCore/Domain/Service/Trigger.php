<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

class Trigger
{
    public function runRequest(string $unpacked, string $imagePrefix, string $containerPrefix)
    {
        $ret = \shell_exec("docker build  --tag {$imagePrefix} {$unpacked}");
        if(null !== $ret){
            $ret = \shell_exec("docker run --rm --name {$containerPrefix} {$imagePrefix}");
        }
    }
}
