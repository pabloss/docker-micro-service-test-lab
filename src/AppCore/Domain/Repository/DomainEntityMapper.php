<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

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
    public function domain2Entity(string $id, uServiceInterface $domain): EntityInterface
    {
        return new uServiceEntity($id,  $domain->movedToDir().$id, $domain->file());
    }
}
