<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\Framework\Application\UnpackZippedFileApplication;
use App\Framework\Event\FileUploadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UnpackFileSubscriber implements EventSubscriberInterface
{
    /**
     * @var UnpackZippedFileApplication
     */
    private $unpackZippedFileApplication;

    /**
     * UnpackFileSubscriber constructor.
     * @param UnpackZippedFileApplication $unpackZippedFileApplication
     */
    public function __construct(UnpackZippedFileApplication $unpackZippedFileApplication)
    {
        $this->unpackZippedFileApplication = $unpackZippedFileApplication;
    }


    public static function getSubscribedEvents()
    {
        return [
            FileUploadedEvent::NAME => ['onUploadedFile', 10]
        ];
    }

    public function onUploadedFile(FileUploadedEvent $event)
    {
        $this->unpackZippedFileApplication->unzipToTargetDir($event->getPhpFiles());
    }

}
