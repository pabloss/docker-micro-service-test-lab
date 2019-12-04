<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service\WebSockets\Context;

/**
 * Class Wrapper
 * @package App\AppCore\Domain\Service\WebSockets
 */
class Wrapper implements WrapperInterface
{
    const TOPIC_ENTRY_DATA_KEY = 'topic';
    const TOPIC_ENTRY_DATA_VALUE = 'entry_data';

    /**
     * @param array $entryData
     * @return array
     */
    public function wrap(array $entryData)
    {
        $entryData[self::TOPIC_ENTRY_DATA_KEY] = self::TOPIC_ENTRY_DATA_VALUE;
        return $entryData;
    }
}
