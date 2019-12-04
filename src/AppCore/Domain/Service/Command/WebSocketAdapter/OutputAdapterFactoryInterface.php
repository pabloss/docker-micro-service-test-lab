<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

interface OutputAdapterFactoryInterface
{
    public function getByOut(int $out);
}