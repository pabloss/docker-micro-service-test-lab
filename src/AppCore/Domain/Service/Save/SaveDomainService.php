<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Save;

use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Factory\EntityFactory;

class SaveDomainService implements SaveDomainServiceInterface
{
    /**
     * @var string
     */
    private $dirName;
    /**
     * @var uServiceRepositoryInterface
     */
    private $repo;
    /**
     * @var EntityFactory
     */
    private $factory;

    /**
     * SaveDomainService constructor.
     *
     * @param string                      $dirName
     * @param uServiceRepositoryInterface $repo
     * @param EntityFactory               $factory
     */
    public function __construct(string $dirName, uServiceRepositoryInterface $repo, EntityFactory $factory)
    {
        $this->dirName = $dirName;
        $this->repo = $repo;
        $this->factory = $factory;
    }

    public function save(string $file)
    {
        $domain = $this->factory->createService($file, $this->dirName);
        $this->repo->persist($domain, null);
        return $domain;
    }
}
