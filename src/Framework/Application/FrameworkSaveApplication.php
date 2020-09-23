<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Application\Save\SaveApplicationInterface;
use App\AppCore\Domain\Actors\FileInterface;

class FrameworkSaveApplication
{
    /**
     * @var SaveApplicationInterface
     */
    private $saveApplication;

    /**
     * FrameworkSaveApplication constructor.
     *
     * @param SaveApplicationInterface $saveApplication
     */
    public function __construct(SaveApplicationInterface $saveApplication)
    {
        $this->saveApplication = $saveApplication;
    }

    public function save(FileInterface $fileToSave, string $targetDir, \DateTime $when)
    {
        $this->saveApplication->save($targetDir, $fileToSave, $when);
    }
}
