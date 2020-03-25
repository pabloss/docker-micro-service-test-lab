<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Application\SaveApplicationInterface;

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


    public function save(string $fileToSave, string $targetDir)
    {
        $this->saveApplication->save($targetDir, $fileToSave);
    }
}
