<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

class Trigger
{
    public function runRequest(string $unpacked, string $imagePrefix, string $containerPrefix, array $params)
    {
        $ret = \shell_exec("docker build  --tag {$imagePrefix} {$unpacked}");
        if(null !== $ret){
            $ret = \shell_exec(
                "docker run -v {$unpacked}:/usr/src/myapp --network=\"host\" " .
                "--rm --name {$containerPrefix} {$imagePrefix} " .
                "php {$params['script']} '{$params['url']}' '{$params['body']}' '{$params['header']}'"
            );
        }
    }
}
