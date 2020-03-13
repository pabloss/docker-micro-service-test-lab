<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;

class uServiceRepository
{
    /**
     * @var PersistGateway
     */
    private $gateway;
    /**
     * @var DomainEntityMapper
     */
    private $mapper;

    /**
     *
     * SOLID up to L concerns one class
     * 1. SRP - OK
     * 2. OCP - NOT
     */


    /**
     * uServiceRepository constructor.
     *
     * @param PersistGateway $gateway
     */
    public function __construct(PersistGateway $gateway, DomainEntityMapper $mapper)
    {
        $this->gateway = $gateway;
        $this->mapper = $mapper;
    }

    public function persist(uService $domain)
    {
        $this->gateway->persist(
            $this->mapper->domain2Entity($this->gateway->nextId(), $domain)
        );
    }

    public function all()
    {
        return $this->gateway->getAll();
    }
}
