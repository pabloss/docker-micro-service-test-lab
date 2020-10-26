<?php
declare(strict_types=1);

namespace App\Framework\Service\Test;

use App\AppCore\Domain\Repository\TestRepositoryInterface;
use App\Framework\Service\Files\Dir;

/**
 * Class Docker
 *
 * @package App\Framework\Service\Test
 */
class Docker
{
    const IMAGE_PREFIX = 'image_prefix';

    const CONTAINER_PREFIX = 'container_prefix';

    /** @var string */
    private $uuid;

    /** @var Dir */
    private $dir;
    /**
     * @var TestRepositoryInterface
     */
    private $testRepository;

    /**
     * Docker constructor.
     *
     * @param Dir                     $dir
     * @param TestRepositoryInterface $testRepository
     */
    public function __construct(Dir $dir, TestRepositoryInterface $testRepository)
    {
        $this->dir = $dir;
        $this->testRepository = $testRepository;
        $this->uuid;

    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function findDockerFileDir(string $uuid): string
    {
        return $this->dir->findParentDir($this->testRepository->findByHash($uuid)->getUService()->getUnpacked(), 'Dockerfile');
    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function createImagePrefix(string $uuid)
    {
        return self::IMAGE_PREFIX . $uuid;
    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function createContainerPrefix(string $uuid)
    {
        return self::CONTAINER_PREFIX . $uuid;
    }
}
