<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\Actors\FileInterface;
use App\AppCore\Domain\Service\SaveDomainService;
use App\AppCore\Domain\Service\SaveDomainServiceInterface;

/**
 * Class SaveApplication
 *
 * @package App\AppCore\Application\Application
 *
 * 1. SRP - OK
 * 2. OCP - OK
 * 3. LSP - the class has no inherited currently
 * 4. ISP - don't know
 * 5. DIP - OK
 */
class SaveApplication implements SaveApplicationInterface
{

    /**
     * @var SaveDomainService
     */
    private $service;
    /**
     * @var SaveToFileSystemInterface
     */
    private $saveToFileSystem;

    /**
     * SaveApplication constructor.
     *
     * @param SaveToFileSystemInterface                              $saveToFileSystem
     * @param SaveDomainServiceInterface $service
     */
    public function __construct(SaveToFileSystemInterface $saveToFileSystem, SaveDomainServiceInterface $service)
    {
        $this->service = $service;
        $this->saveToFileSystem = $saveToFileSystem;
    }


    public function save(string $dir, FileInterface $file)
    {
        $this->service->save($this->saveToFileSystem->move($dir, $file)->getPath());
    }
}
