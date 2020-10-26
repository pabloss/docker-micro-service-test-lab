<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Test;

use App\AppCore\Domain\Actors\TestDTO;
use function shell_exec;

class Trigger
{
    public function runRequest(string $unpacked, string $imagePrefix, string $containerPrefix, TestDTO $testDTO)
    {
        $ret = shell_exec("docker build  --tag {$imagePrefix} {$unpacked}");
        if (null !== $ret) {
            exec(
                "docker run -v {$unpacked}:/usr/src/myapp --network=\"host\" " .
                "--rm --name {$containerPrefix} {$imagePrefix} " .
                "php {$testDTO->getScript()} '{$testDTO->getUrl()}' '{$testDTO->getBody()}' '{$testDTO->getHeader()}'"
            , $output, $ret);
        }
    }
}
