<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Status;

use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Repository\StatusRepositoryInterface;
use DateTime;

class SaveStatus
{
    /**
     * @var StatusRepositoryInterface
     */
    private $statusRepository;
    /**
     * @var EntityFactoryInterface
     */
    private $entityFactory;

    /**
     * SaveStatus constructor.
     *
     * @param StatusRepositoryInterface $statusRepository
     * @param EntityFactoryInterface    $entityFactory
     */
    public function __construct(StatusRepositoryInterface $statusRepository, EntityFactoryInterface $entityFactory)
    {
        $this->statusRepository = $statusRepository;
        $this->entityFactory = $entityFactory;
    }

    public function save(string $uuid, string $statusString, DateTime $now)
    {
        $this->statusRepository->save($this->entityFactory->createStatusEntity($uuid, $statusString, $now));
    }
}
