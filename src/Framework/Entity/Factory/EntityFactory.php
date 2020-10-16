<?php
declare(strict_types=1);

namespace App\Framework\Entity\Factory;

use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Actors\StatusEntityInterface;
use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\uServiceEntityInterface;
use App\Framework\Entity\Status;
use App\Framework\Entity\Test;
use App\Framework\Entity\UService;
use DateTime;

class EntityFactory implements EntityFactoryInterface
{
    public function createService(string $file, string $movedToDir): uServiceEntityInterface
    {
        $UService = new UService();
        $UService->setFile($file);
        $UService->setMovedToDir($movedToDir);
        $UService->setCreated(new DateTime());
        return $UService;
    }

    public function createTest(TestDTO $testDTO): TestEntityInterface
    {
        $test = new Test();
        $test->setUuid($testDTO->getUuid());
        $test->setRequestedBody($testDTO->getRequestedBody());
        $test->setBody($testDTO->getBody());
        $test->setHeader($testDTO->getHeader());
        $test->setUrl($testDTO->getUrl());
        $test->setScript($testDTO->getScript());
        return $test;
    }

    public function createStatusEntity(string $uuid, string $statusString, DateTime $now): StatusEntityInterface
    {
        $status = new Status();
        $status->setUuid($uuid);
        $status->setStatusName($statusString);
        $status->setCreated($now);
        return $status;
    }
}
