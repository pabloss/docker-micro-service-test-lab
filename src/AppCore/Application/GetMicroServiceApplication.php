<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Entity\Test;
use App\Framework\Entity\UService;
use function array_map;

class GetMicroServiceApplication
{
    /**
     * @var uServiceRepositoryInterface
     */
    private $repository;
    /**
     * @var TestRepositoryInterface
     */
    private $testRepository;

    /**
     * GetMicroService constructor.
     *
     * @param uServiceRepositoryInterface $repository
     * @param TestRepositoryInterface     $testRepository
     */
    public function __construct(uServiceRepositoryInterface $repository, TestRepositoryInterface $testRepository)
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
        return $this->repository->findByHash($uuid)->getTests()->first()->getRequestedBody();
    }

    public function getAllAsArray()
    {
        return array_map(function (UService $uService) {
            return 0 === $uService->getTests()->count() ?
                [
                    'uuid' => $uService->getUuid(),
                    'url' => '',
                    'script' => '',
                    'header' => '',
                    'requested_body' => '',
                    'body' => '',
                ]
                :
                Test::asArray($uService->getTests()->last());
        }, $this->getAll());
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
