<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Actors\uService;

class Trigger
{
    /**
     * Trigger constructor.
     */
    public function __construct()
    {
    }

    public function runRequest(uService $service, string $imagePrefix, string $containerPrefix)
    {
        $ret = \shell_exec("docker build  --tag {$imagePrefix} {$service->unpacked()}");
        if(null !== $ret){
            $ret = \shell_exec("docker run -it --rm --name {$containerPrefix} {$imagePrefix}");
        }
    }
}
