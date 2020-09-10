<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Actors\uServiceInterface;

/**
 *
 * 1. SRP - OK
 * 2. OCP - OK
 * 3. LSP - don't know
 * 4. SIP - OK
 * 5. DIP - OK
 * Class DomainEntityMapper
 *
 * @package App\AppCore\Domain\Repository
 */
class DomainEntityMapper implements DomainEntityMapperInterface
{
    public function domain2Entity(?string $id, uServiceInterface $domain): uServiceEntityInterface
    {
        $uServiceEntity = new uServiceEntity($domain->getMovedToDir(), $domain->getFile(), $id);
        if(null !== $domain->getUnpacked()){
            $uServiceEntity->setUnpacked($domain->getUnpacked());
        }
        return $uServiceEntity;
    }

    public function entity2Domain(uServiceEntityInterface $entity): uServiceInterface
    {
        $uService = new uService($entity->getFile(), $entity->getMovedToDir());
        if(null !== $entity->getUnpacked()){
            $uService->setUnpacked($entity->getUnpacked());
        }
        return $uService;
    }
}
