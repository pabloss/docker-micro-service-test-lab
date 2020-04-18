<?php
declare(strict_types=1);

namespace App\Framework\Persistence;

use App\AppCore\Domain\Repository\EntityInterface;
use App\AppCore\Domain\Repository\PersistGatewayInterface;
use App\AppCore\Domain\Repository\uServiceEntity;
use App\Framework\Entity\UService;
use Doctrine\ORM\EntityManagerInterface;

class PersistGatewayAdapter implements PersistGatewayInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function nextId()
    {
        return $this->entityManager->getRepository(UService::class)->count([])+1;
    }

    public function getAll()
    {
        return $this->entityManager->getRepository(UService::class)->findAll();
    }

    public function persist(EntityInterface $uServiceEntity)
    {
        $this->entityManager->persist(UService::fromDomainEntity($uServiceEntity));
        $this->entityManager->flush();
    }

    public function find(string $id)
    {
        return new uServiceEntity(
            $id,
            $this->entityManager->getRepository(UService::class)->find($id)->getMovedToDir(),
            $this->entityManager->getRepository(UService::class)->find($id)->getFile()
        );
    }

}
