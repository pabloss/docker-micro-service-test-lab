<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\Command\WebSocketAdapter;

use App\AppCore\Domain\Service\Command\FetchOutInterface;
use App\AppCore\Domain\Service\Command\OutputAdapterInterface;

class AdaptersContainer extends \ArrayObject implements FetchOutInterface
{
    public function fetchedOut($pipes): bool
    {
        $return = false;
        $arrayIterator = $this->getIterator();
        while ($arrayIterator->valid() && $arrayIterator->current() instanceof OutputAdapterInterface){
            $return = $return || $arrayIterator->current()->fetchedOut($pipes);
            $arrayIterator->next();
        }
        return $return;
    }
}
