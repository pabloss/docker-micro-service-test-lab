<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Repository\StatusRepositoryInterface;
use App\Framework\Factory\EntityFactory;

class SaveStatus
{
    /**
     * @var StatusRepositoryInterface
     */
    private $statusRepository;
    /**
     * @var EntityFactory
     */
    private $entityFactory;

    /**
     * SaveStatus constructor.
     *
     * @param StatusRepositoryInterface $statusRepository
     * @param EntityFactory             $entityFactory
     */
    public function __construct(StatusRepositoryInterface $statusRepository, EntityFactory $entityFactory)
    {
        $this->statusRepository = $statusRepository;
        $this->entityFactory = $entityFactory;
    }

    public function save(string $uuid, string $statusString, \DateTime $now)
    {
        $this->statusRepository->save($this->entityFactory->createStatusEntity($uuid, $statusString, $now));
    }
}
