<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\Test;

class TestRepository
{
    /**
     * @var PersistGatewayInterface
     */
    private $gateway;
    /**
     * @var TestDomainEntityMapperInterface
     */
    private $mapper;

    /**
     * uServiceRepository constructor.
     *
     * @param PersistGatewayInterface         $gateway
     * @param TestDomainEntityMapperInterface $mapper
     */
    public function __construct(PersistGatewayInterface $gateway, TestDomainEntityMapperInterface $mapper)
    {
        $this->gateway = $gateway;
        $this->mapper = $mapper;
    }

    public function findByHash(string $uuid)
    {
        return $this->mapper->entity2Domain($this->gateway->findByHash($uuid));
    }

    public function persist(Test $domain, $nextId)
    {
        $this->gateway->persist($this->mapper->domain2Entity($nextId, $domain));
    }

    public function all()
    {
        return $this->gateway->getAll();
    }

    public function find($nextId)
    {
        return $this->mapper->entity2Domain($this->gateway->find($nextId));
    }
}
