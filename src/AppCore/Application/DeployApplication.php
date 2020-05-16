<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\Build\BuildServiceInterface;
use App\AppCore\Domain\Service\Build\Unpack\UnpackServiceInterface;
use App\AppCore\Domain\Service\Command\CommandFactoryInterface;
use App\MixedContext\Domain\Service\Files\Dir;

class DeployApplication
{
    const FILE_TO_FIND = 'Dockerfile';
    /**
     * @var \App\AppCore\Domain\Service\Build\Unpack\UnpackServiceInterface
     */
    private $service;
    /**
     * @var uServiceRepositoryInterface
     */
    private $repository;
    /**
     * @var BuildServiceInterface
     */
    private $buildService;
    /**
     * @var Dir
     */
    private $dir;
    /**
     * @var CommandFactoryInterface
     */
    private $commandFactory;

    /**
     * DeployApplication constructor.
     *
     * @param UnpackServiceInterface                                      $service
     * @param \App\AppCore\Domain\Service\Build\BuildServiceInterface     $buildService
     * @param Dir                                                         $dir
     * @param \App\AppCore\Domain\Service\Command\CommandFactoryInterface $commandFactory
     * @param uServiceRepositoryInterface                                 $repository
     */
    public function __construct(UnpackServiceInterface $service, BuildServiceInterface $buildService, Dir $dir, CommandFactoryInterface $commandFactory,   uServiceRepositoryInterface $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->buildService = $buildService;
        $this->dir = $dir;
        $this->commandFactory = $commandFactory;
    }

    public function deploy(string $id, string $targetDir, string $imagePrefix, string $containerPrefix)
    {
        $this->repository->persist(
            $this->service->unpack($this->repository->find($id), $targetDir), $id
        );

        $this->buildService->build($this->createCommandCollection($id, $imagePrefix, $containerPrefix));
    }

    /**
     * @param string $id
     * @param string $imagePrefix
     * @param string $containerPrefix
     *
     * @return mixed
     */
    private function createCommandCollection(string $id, string $imagePrefix, string $containerPrefix)
    {
        return $this->commandFactory->createCollection(
            [
                $this->commandFactory->createCommand(
                    'build',
                    $this->dir->findFile($this->repository->find($id)->unpacked(), self::FILE_TO_FIND),
                    $imagePrefix . "_$id"
                ),
                $this->commandFactory->createCommand('run', $containerPrefix . "_$id", $imagePrefix . "_$id"),
            ]
        );
}
}
