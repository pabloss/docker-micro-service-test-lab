<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\UnpackService;

class DeployApplication
{
    /**
     * @var UnpackService
     */
    private $service;
    /**
     * @var uServiceRepositoryInterface
     */
    private $repository;

    /**
     * DeployApplication constructor.
     *
     * @param UnpackService               $service
     * @param uServiceRepositoryInterface $repository
     */
    public function __construct(\App\AppCore\Domain\Service\UnpackService $service, uServiceRepositoryInterface $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function deploy(string $id, string $targetDir)
    {
        $this->repository->persist(
            $this->service->unpack($this->repository->find($id), $targetDir)
        );
    }
}
