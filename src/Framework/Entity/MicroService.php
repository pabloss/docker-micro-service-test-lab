<?php
declare(strict_types=1);

namespace App\Framework\Entity;


/**
 * Class MicroService
 * @package App\Framework\Entity
 */
class MicroService
{
    /**
     * @var string
     */
    private $microServicePackedFilename;

    /**
     * @return string
     */
    public function getMicroServicePackedFilename(): string
    {
        return $this->microServicePackedFilename;
    }

    /**
     * @param string $microServicePackedFilename
     * @return $this
     */
    public function setMicroServicePackedFilename(string $microServicePackedFilename)
    {
        $this->microServicePackedFilename = $microServicePackedFilename;

        return $this;
    }
}

