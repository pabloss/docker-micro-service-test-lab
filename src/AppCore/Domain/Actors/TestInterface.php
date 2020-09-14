<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

interface TestInterface
{
    public function getUuid(): string;
    public function getRequestedBody(): string;
    public function getBody(): string;
    public function getHeader(): string;
    public function getScript(): string;
    public function getUrl(): string;
}
