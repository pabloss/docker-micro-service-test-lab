<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uServiceInterface;

/**
 * 1. SRP - OK
 * 2. OCP - OK
 * 3. LSP - don't know
 * 4. ISP - not applicable
 * 5. DIP - OK
 * Class uServiceRepository
 *
 * @package App\AppCore\Domain\Repository
 */
class uServiceRepository implements uServiceRepositoryInterface
{
    /**
     * @var PersistGatewayInterface
     */
    private $gateway;
    /**
     * @var DomainEntityMapper
     */
    private $mapper;

    /**
     * uServiceRepository constructor.
     *
     * @param PersistGatewayInterface     $gateway
     * @param DomainEntityMapperInterface $mapper
     */
    public function __construct(PersistGatewayInterface $gateway, DomainEntityMapperInterface $mapper)
    {
        $this->gateway = $gateway;
        $this->mapper = $mapper;
    }

    public function persist(uServiceInterface $domain, ?string $id)
    {
        $this->gateway->persist(
            $this->mapper->domain2Entity($id, $domain)
        );
    }

    public function all()
    {
        return $this->gateway->getAll();
    }

    public function find(string $id)
    {
        return $this->mapper->entity2Domain($this->gateway->find($id));
    }
}
