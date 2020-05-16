<?php
declare(strict_types=1);

namespace App\Tests\unit\Integration\Stubs;

use App\AppCore\Domain\Service\Command\CommandInterface;

class TestCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function command(): string
    {
        return "echo {$this->input}";
    }

}
