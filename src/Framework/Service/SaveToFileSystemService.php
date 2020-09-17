<?php
declare(strict_types=1);

namespace App\Framework\Service;

use App\AppCore\Application\Save\SaveToFileSystemInterface;
use App\AppCore\Domain\Actors\FileInterface;
use App\AppCore\Domain\Repository\uServiceRepositoryInterface;
use App\Framework\Entity\Status;
use App\Framework\Factory\EntityFactory;
use App\Framework\Subscriber\Event\SaveStatusEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SaveToFileSystemService implements SaveToFileSystemInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var uServiceRepositoryInterface
     */
    private $serviceRepository;
    /**
     * @var Uuid
     */
    private $uuid;
    /**
     * @var EntityFactory
     */
    private $entityFactory;

    public function __construct(EventDispatcherInterface $eventDispatcher, uServiceRepositoryInterface $serviceRepository, EntityFactory $entityFactory, Uuid $uuid)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->serviceRepository = $serviceRepository;
        $this->uuid = $uuid;
        $this->entityFactory = $entityFactory;
    }

    public function move(string $targetDir, FileInterface $domainUploadedFile): FileInterface
    {
        $file = $domainUploadedFile->move($targetDir);
        $this->eventDispatcher->dispatch(
            new SaveStatusEvent($this->entityFactory->createStatusEntity(
                $this->uuid->getUuidFromDir(\dirname($file->getPath())),
                'file_moved',
                new \DateTime()
            )),
            SaveStatusEvent::NAME
        );
        return $file;
    }
}
