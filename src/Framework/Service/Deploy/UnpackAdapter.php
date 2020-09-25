<?php
declare(strict_types=1);

namespace App\Framework\Service\Deploy;

use App\AppCore\Domain\Actors\Factory\EntityFactoryInterface;
use App\AppCore\Domain\Service\Deploy\Build\Unpack\UnpackInterface;
use App\Framework\Service\Uuid;
use App\Framework\Subscriber\Event\SaveStatusEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UnpackAdapter implements UnpackInterface
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
     * @var EntityFactoryInterface
     */
    private $entityFactory;


    /**
     * UnpackAdapter constructor.
     *
     * @param \ZipArchive              $zipArchive
     * @param EventDispatcherInterface $eventDispatcher
     * @param EntityFactoryInterface   $entityFactory
     * @param Uuid                     $uuid
     */
    public function __construct(\ZipArchive $zipArchive, EventDispatcherInterface $eventDispatcher, EntityFactoryInterface $entityFactory, Uuid $uuid)
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
