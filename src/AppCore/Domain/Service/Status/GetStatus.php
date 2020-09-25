<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Status;

use App\AppCore\Domain\Repository\StatusRepositoryInterface;

class GetStatus
{
    /**
     * @var StatusRepositoryInterface
     */
    private $statusRepository;

    /**
     * GetStatus constructor.
     *
     * @param StatusRepositoryInterface $statusRepository
     */
    public function __construct(StatusRepositoryInterface $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function getById($id)
    {
        return $this->statusRepository->get($id);
    }

    public function getByHash(string $uuid)
    {
        return $this->statusRepository->findByHash($uuid);
    }
}


