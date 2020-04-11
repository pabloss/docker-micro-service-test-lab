<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Actors\uService;

class UnpackService implements UnpackServiceInterface
{

    /**
     * UnpackService constructor.
     */
    public function __construct()
    {
    }

    public function unpack()
    {
        return new uService('', '');
    }
}
