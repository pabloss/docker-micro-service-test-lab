<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

interface SaveDomainServiceInterface
{
    public function save(string $file);
}
