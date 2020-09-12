<?php
declare(strict_types=1);

namespace App\Framework\Factory;

use App\AppCore\Domain\Repository\uServiceEntityInterface;
use App\Framework\Entity\UService;

class EntityFactory
{

    /**
     * EntityFactory constructor.
     */
    public function __construct()
    {
    }

    public function createService(string $file, string $movedToDir): uServiceEntityInterface
    {
        $UService = new UService();
        $UService->setFile($file);
        $UService->setMovedToDir($movedToDir);
        return $UService;
    }
}
