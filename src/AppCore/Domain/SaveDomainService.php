<?php
declare(strict_types=1);

namespace App\AppCore\Domain;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\uServiceRepository;

class SaveDomainService
{
    /**
     * @var string
     */
    private $dirName;
    /**
     * @var uServiceRepository
     */
    private $repo;

    /**
     * SaveDomainService constructor.
     *
     * @param string             $dirName
     * @param uServiceRepository $repo
     */
    public function __construct(string $dirName, uServiceRepository $repo)
    {
        $this->dirName = $dirName;
        $this->repo = $repo;
    }

    public function save(string $file)
    {
        $domain = new uService($file, $this->dirName);
        $this->repo->persist($domain);
        return $domain;
    }
}
