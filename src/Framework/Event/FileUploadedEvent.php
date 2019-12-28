<?php
declare(strict_types=1);

namespace App\Framework\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class FileUploadedEvent
 *
 * @package App\Framework\Event
 * @codeCoverageIgnore
 */
class FileUploadedEvent extends Event implements FileUploadedEventInterface
{
    public const NAME = 'file.uploaded';

    /**
     * @var array
     */
    protected $phpFiles;

    /**
     * FileUploadedEvent constructor.
     * @param array $phpFiles
     */
    public function __construct(array $phpFiles)
    {
        $this->phpFiles = $phpFiles;
    }

    /**
     * @return array
     */
    public function getPhpFiles(): array
    {
        return $this->phpFiles;
    }
}
