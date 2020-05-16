<?php
declare(strict_types=1);

namespace App\Tests\unit\Integration\Stubs;

class OutPutAdapter implements \App\AppCore\Domain\Service\OutPutInterface
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
