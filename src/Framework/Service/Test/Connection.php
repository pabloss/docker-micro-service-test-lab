<?php
declare(strict_types=1);

namespace App\Framework\Service\Test;

use App\Framework\Repository\ConnectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Framework\Entity\Connection as ConnectionEntity;

class Connection
{
    /**
     * @var ConnectionRepository
     */
    private $connectionRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connectionRepository = $this->entityManager->getRepository(ConnectionEntity::class);
    }

    public function getNextUuid(string $uuid): string
    {
        return null !== ($connection = $this->connectionRepository->findByFirstUuid($uuid)) ? $connection->getUuid2(): '';
    }

    public function make(string $uuid1, string $uuid2)
    {
        $entity = new ConnectionEntity();
        $entity->setUuid1($uuid1);
        $entity->setUuid2($uuid2);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
