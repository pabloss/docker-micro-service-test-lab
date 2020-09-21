<?php
declare(strict_types=1);

namespace App\Framework\Subscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AfterSavingService extends Event
{
    const NAME = 'update.status.after.service.saved';

    /** @var string */
    private $uuid;

    /**
     * AfterSavingService constructor.
     *
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
