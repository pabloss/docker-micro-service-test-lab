<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Actors\uService;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;

class GetFileService
{
    /**
     * @var uServiceRepositoryInterface
     */
    private $repo;

    /**
     * GetFileService constructor.
     *
     * @param uServiceRepositoryInterface $repo
     */
    public function __construct(uServiceRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getService($id): uService
    {
        return $this->repo->find($id);
    }
}
