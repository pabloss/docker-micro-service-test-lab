<?php
declare(strict_types=1);

namespace App\MixedContext\Domain\Service\Command\WebSocketAdapter;

interface OutputAdapterFactoryInterface
{
    public function getByOut(int $out);
}
