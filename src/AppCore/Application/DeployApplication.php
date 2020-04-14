<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\UnpackServiceInterface;

class DeployApplication
{
    /**
     * @var UnpackServiceInterface
     */
    private $service;
    /**
     * @var uServiceRepositoryInterface
     */
    private $repository;

    /**
     * DeployApplication constructor.
     *
     * @param UnpackServiceInterface      $service
     * @param uServiceRepositoryInterface $repository
     */
    public function __construct(UnpackServiceInterface $service, uServiceRepositoryInterface $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function deploy(string $id, string $targetDir)
    {
        $this->repository->persist(
            $this->service->unpack(
                $this->repository->find($id),
                $targetDir
            )
        );
    }
}
