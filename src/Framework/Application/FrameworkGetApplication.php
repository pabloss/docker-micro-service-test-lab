<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Service\GetFileService;

class FrameworkGetApplication
{
    /**
     * @var GetFileService
     */
    private $service;

    /**
     * FrameworkGetApplication constructor.
     *
     * @param GetFileService $service
     */
    public function __construct(GetFileService $service)
    {
        $this->service = $service;
    }


    public function getFile(int $param)
    {
        return new \SplFileInfo($this->service->getService((string)$param)->getMovedToDir().'/'.$this->service->getService((string)$param)->getFile());
    }
}
