<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\Test;
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
     * @var TestDomainEntityMapper
     */
    private $testDomainEntityMapper;

    /**
     * uServiceRepository constructor.
     *
     * @param PersistGatewayInterface         $gateway
     * @param DomainEntityMapperInterface     $mapper
     * @param TestDomainEntityMapperInterface $testDomainEntityMapper
     */
    public function __construct(PersistGatewayInterface $gateway, DomainEntityMapperInterface $mapper, TestDomainEntityMapperInterface $testDomainEntityMapper)
    {
        $this->gateway = $gateway;
        $this->mapper = $mapper;
        $this->testDomainEntityMapper = $testDomainEntityMapper;
    }

    public function persist(uServiceInterface $domain, ?string $id)
    {
        $this->gateway->persist(
            null === $domain->getTest() ? $this->mapper->domain2Entity($id, $domain):  $this->mapper->domain2Entity($id, $domain)->setTest($this->mapTestDomain($domain))
        );
    }

    public function all()
    {
        return \array_map(function ($entity){
            return $this->mapper->entity2Domain($entity)->setTest(
                $this->mapTestEntity($entity->uuid())
            );
        }, $this->gateway->getAll());
    }

    public function find(string $id)
    {
        return $this->mapper->entity2Domain($this->gateway->find($id));
    }

    public function findByHash(string $hash)
    {
        return $this->mapper->entity2Domain(
            $this->gateway->findByHash($hash))->setTest($this->mapTestEntity($hash)
        );
    }

    /**
     * @param uServiceInterface $domain
     *
     * @return TestEntity
     */
    private function mapTestDomain(uServiceInterface $domain): TestEntity
    {
        return $this->testDomainEntityMapper->domain2Entity(null, $domain->getTest());
    }

    /**
     * @param string $hash
     *
     * @return Test
     */
    private function mapTestEntity(string $hash): Test
    {
        return $this->testDomainEntityMapper->entity2Domain($this->gateway->findByHash($hash)->getTest());
    }

}
