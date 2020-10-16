<?php
declare(strict_types=1);

namespace App\Framework\Subscriber\Event;

use App\Framework\Entity\Status;
use Symfony\Contracts\EventDispatcher\Event;

class SaveStatusEvent extends Event
{
    const NAME = 'save.status';

    /** @var Status */
    private $statusEntity;

    /**
     * SaveStatusEvent constructor.
     *
     * @param Status $statusEntity
     */
    public function __construct(Status $statusEntity)
    {
        $this->statusEntity = $statusEntity;
    }

    /**
     * @return Status
     */
    public function getStatusEntity(): Status
    {
        return $this->statusEntity;
    }
}
