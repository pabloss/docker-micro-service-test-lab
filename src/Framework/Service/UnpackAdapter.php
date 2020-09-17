<?php
declare(strict_types=1);

namespace App\Framework\Service;

use App\Framework\Entity\Status;
use App\Framework\Factory\EntityFactory;
use App\Framework\Subscriber\Event\SaveStatusEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UnpackAdapter implements \App\AppCore\Domain\Service\Build\Unpack\UnpackInterface
{

    private $zipArchive;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    /**
     * @var Uuid
     */
    private $uuid;
    /**
     * @var EntityFactory
     */
    private $entityFactory;


    /**
     * UnpackAdapter constructor.
     *
     * @param \ZipArchive              $zipArchive
     * @param EventDispatcherInterface $eventDispatcher
     * @param EntityFactory            $entityFactory
     * @param Uuid                     $uuid
     */
    public function __construct(\ZipArchive $zipArchive, EventDispatcherInterface $eventDispatcher, EntityFactory $entityFactory, Uuid $uuid)
    {
        $this->zipArchive = $zipArchive;
        $this->eventDispatcher = $eventDispatcher;
        $this->uuid = $uuid;
        $this->entityFactory = $entityFactory;
    }

    public function unpack(string $zipFilePath, string $dirName)
    {
        if ($this->zipArchive->open($zipFilePath) === true) {
            $extractTo = $this->zipArchive->extractTo($dirName);
            $close = $this->zipArchive->close();
            $this->eventDispatcher->dispatch(
                new SaveStatusEvent($this->entityFactory->createStatusEntity(
                    $this->uuid->getUuidFromDir($dirName),
                    'file_unpacked',
                    new \DateTime()
                )),
                SaveStatusEvent::NAME
            );
            return $extractTo && $close;
        } else {
            return false;
        }
    }
}
