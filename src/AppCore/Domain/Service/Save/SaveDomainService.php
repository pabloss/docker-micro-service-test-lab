<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Save;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;

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
     * SaveDomainService constructor.
     *
     * @param string                      $dirName
     * @param uServiceRepositoryInterface $repo
     */
    public function __construct(string $dirName, uServiceRepositoryInterface $repo)
    {
        $this->dirName = $dirName;
        $this->repo = $repo;
    }

    public function save(string $file)
    {
        $domain = new uService($file, $this->dirName);
        $this->repo->persist($domain, null);
        return $domain;
    }
}
