<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Repository;

use App\AppCore\Domain\Actors\uService;

class DomainEntityMapper
{
    public function domain2Entity(string $id, uService $domain): uServiceEntity
    {
        return new uServiceEntity($id,  $domain->movedToDir().$id, $domain->fileName());
    }
}
