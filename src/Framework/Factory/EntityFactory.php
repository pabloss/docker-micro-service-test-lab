<?php
declare(strict_types=1);

namespace App\Framework\Factory;

use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\uServiceEntityInterface;
use App\Framework\Entity\Test;
use App\Framework\Entity\UService;

class EntityFactory
{

    /**
     * EntityFactory constructor.
     */
    public function __construct()
    {
    }

    public function createService(string $file, string $movedToDir): uServiceEntityInterface
    {
        $UService = new UService();
        $UService->setFile($file);
        $UService->setMovedToDir($movedToDir);
        return $UService;
    }

    public function createTest(
        string $uuid,
        string $requestedBody,
        string $body,
        string $header,
        string $url,
        string $script
    ): Test {
        $test = new Test();
        $test->setUuid($uuid);
        $test->setRequestedBody($requestedBody);
        $test->setBody($body);
        $test->setHeader($header);
        $test->setRequestedBody($requestedBody);
        $test->setUrl($url);
        $test->setScript($script);
        return $test;
    }
}
