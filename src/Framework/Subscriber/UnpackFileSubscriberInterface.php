<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\Framework\Event\FileUploadedEvent;

interface UnpackFileSubscriberInterface
{
    public function onUploadedFile(FileUploadedEvent $event);
}