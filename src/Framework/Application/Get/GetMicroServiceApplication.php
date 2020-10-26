<?php
declare(strict_types=1);

namespace App\Framework\Application\Get;

use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Entity\Status;
use App\Framework\Entity\Test;
use App\Framework\Entity\UService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use function array_map;

const DB_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * GetMicroService constructor.
     *
     * @param uServiceRepositoryInterface $repository
     * @param TestRepositoryInterface     $testRepository
     * @param EntityManagerInterface      $entityManager
     */
    public function __construct(uServiceRepositoryInterface $repository, TestRepositoryInterface $testRepository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->testRepository = $testRepository;
        $this->entityManager = $entityManager;
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
        /** @var QueryBuilder $qb */
        $qb = $this->entityManager->getRepository(Status::class)->createQueryBuilder('s');
        $qb->where('s.UService = :uService')
            ->orderBy('s.created', 'desc')
            ->setMaxResults(1);
        return array_map(function (UService $uService) use ($qb) {
            $status = $qb->setParameter('uService', $uService)->getQuery()->getOneOrNullResult();
            return 0 === $uService->getTests()->count() ?
                [
                    'uuid' => $uService->getUuid(),
                    'created' => $uService->getCreated()->format(DB_DATE_TIME_FORMAT),
                    'updated' => $status ? $status->getCreated()->format(DB_DATE_TIME_FORMAT): '',
                    'url' => '',
                    'script' => '',
                    'header' => '',
                    'requested_body' => '',
                    'body' => '',
                ]
                :
                \array_merge(
                    Test::asArray($uService->getTests()->last()),
                    [
                        'created' => $uService->getCreated()->format(DB_DATE_TIME_FORMAT),
                        'updated' => $status ? $status->getCreated()->format(DB_DATE_TIME_FORMAT): '',
                    ]
                );
        }, $this->getAll());
    }

    public function getAllUuids()
    {
        return array_map(function (UService $uService){
            return $uService->getUuid();
        }, $this->getAll());
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
