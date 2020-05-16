<?php
declare(strict_types=1);

namespace App\Tests\unit\Integration\Stubs;

class WatcherAdapter implements \App\AppCore\Domain\Service\Command\WatcherInterface
{
    private $outs;

    public function __construct()
    {
        $this->outs = '';
    }

    public function writeln(string $output)
    {
        $this->outs = $output;
    }

    /**
     */
    public function getOuts(): string
    {
        return $this->outs;
    }
}
