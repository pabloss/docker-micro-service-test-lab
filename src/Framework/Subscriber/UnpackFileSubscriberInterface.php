<?php
declare(strict_types=1);

namespace App\Framework\Subscriber;

use App\Framework\Event\FileUploadedEvent;
use App\Framework\Event\FileUploadedEventInterface;

interface UnpackFileSubscriberInterface
{
    public function onUploadedFile(FileUploadedEventInterface $event);
}