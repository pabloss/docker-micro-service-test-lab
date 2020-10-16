<?php
declare(strict_types=1);

namespace App\Framework\Subscriber\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AfterSavingTestEvent extends Event
{
    const NAME = 'update.test.after.test.saved';

    /** @var string */
    private $uuid;

    /**
     * AfterSavingTestEvent constructor.
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
