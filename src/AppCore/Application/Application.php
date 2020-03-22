<?php
declare(strict_types=1);

namespace App\AppCore;

use App\AppCore\Domain\Repository\uServiceEntity;

class Application
{

    /**
     * Application constructor.
     *
     * @param object $saveDomainService
     * @param object $deployDomainService
     * @param object $testDomainService
     * @param object $monitorDomainService
     */
    public function __construct(
        object $saveDomainService,
        object $deployDomainService,
        object $testDomainService,
        object $monitorDomainService
    ) {}

    public function save(uServiceEntity $entity)
    {

    }
}
