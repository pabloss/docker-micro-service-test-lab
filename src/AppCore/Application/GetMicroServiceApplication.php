<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Actors\Test;
use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\TestRepository;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;

class GetMicroServiceApplication
{
    /**
     * @var uServiceRepositoryInterface
     */
    private $repository;
    /**
     * @var TestRepository
     */
    private $testRepository;

    /**
     * GetMicroService constructor.
     *
     * @param uServiceRepositoryInterface $repository
     * @param TestRepository              $testRepository
     */
    public function __construct(uServiceRepositoryInterface $repository, TestRepository $testRepository)
    {
        $this->repository = $repository;
        $this->testRepository = $testRepository;
    }

    public function getUService(string $uuid)
    {
        return $this->repository->findByHash($uuid);
    }

    public function getTestRequestedBody(string $uuid)
    {
        return $this->repository->findByHash($uuid)->getTest()->getRequestedBody();
    }

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getAllAsArray()
    {
        return \array_map(function (uService $uService) {
            return Test::asArray($uService->getTest());
        }, $this->getAll());
    }
}
