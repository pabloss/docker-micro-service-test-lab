<?php
declare(strict_types=1);

namespace App\Framework\Service;

use App\Framework\Entity\Connection;
use Doctrine\ORM\EntityManagerInterface;

class MakeConnection
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * MakeConnection constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function make(string $uniqid1, string $uniqid2)
    {
        $entity = new Connection();
        $entity->setUuid1($uniqid1);
        $entity->setUuid2($uniqid2);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
