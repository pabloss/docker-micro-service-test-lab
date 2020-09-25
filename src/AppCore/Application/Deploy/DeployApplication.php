<?php
declare(strict_types=1);

namespace App\AppCore\Application\Deploy;

use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\AppCore\Domain\Service\Deploy\Build\BuildServiceInterface;
use App\AppCore\Domain\Service\Deploy\Build\Unpack\UnpackServiceInterface;
use App\AppCore\Domain\Service\Deploy\Command\CommandFactoryInterface;
use App\Framework\Service\Files\Dir;

class DeployApplication
{
    const FILE_TO_FIND = 'Dockerfile';
    /**
     * @var UnpackServiceInterface
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
     * @param UnpackServiceInterface      $service
     * @param BuildServiceInterface       $buildService
     * @param Dir                         $dir
     * @param CommandFactoryInterface     $commandFactory
     * @param uServiceRepositoryInterface $repository
     */
    public function __construct(
        UnpackServiceInterface $service,
        BuildServiceInterface $buildService,
        Dir $dir,
        CommandFactoryInterface $commandFactory,
        uServiceRepositoryInterface $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
        $this->buildService = $buildService;
        $this->dir = $dir;
        $this->commandFactory = $commandFactory;
    }

    public function deploy(string $id, string $targetDir, string $imagePrefix, string $containerPrefix)
    {
        $this->repository->persist(
            $this->service->unpack($this->repository->find($id), $targetDir)
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
                    $this->dir->findFile($this->repository->find($id)->getUnpacked(), self::FILE_TO_FIND),
                    $imagePrefix . "_$id"
                ),
                $this->commandFactory->createCommand('run', $containerPrefix . "_$id", $imagePrefix . "_$id"),
            ]
        );
    }
}
