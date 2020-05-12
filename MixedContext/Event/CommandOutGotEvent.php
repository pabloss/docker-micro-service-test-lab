<?php
declare(strict_types=1);

namespace App\MixedContext\Event;


use Symfony\Contracts\EventDispatcher\Event;

class CommandOutGotEvent extends Event
{
    public const NAME = 'command.out.got';
    /**
     * CommandOutGot constructor.
     *
     * @param false|string $out
     * @param int          $STDOUT
     */
    public function __construct(string $out, int $STDOUT)
    {}}
