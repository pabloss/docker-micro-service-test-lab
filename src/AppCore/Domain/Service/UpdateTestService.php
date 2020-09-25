<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Actors\TestDTO;
use App\AppCore\Domain\Repository\TestEntityInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;

class UpdateTestService
{
    /**
     * @var uServiceRepositoryInterface
     */
    private $uServiceRepository;

    public function __construct(uServiceRepositoryInterface $uServiceRepository)
    {
        $this->uServiceRepository = $uServiceRepository;
    }

    public function update(TestEntityInterface $test, TestDTO $testDTO): TestEntityInterface
    {
        $test->setUuid($testDTO->getUuid());
        $test->setUrl($testDTO->getUrl());
        $test->setScript($testDTO->getScript());
        $test->setHeader($testDTO->getHeader());
        $test->setBody($testDTO->getBody());
        $test->setRequestedBody($testDTO->getRequestedBody());
        $test->setUService(
            $this->uServiceRepository->findByHash($testDTO->getUuid())
        );
        return $test;
    }
}
