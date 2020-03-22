<?php
declare(strict_types=1);

namespace App\AppCore\Application;

use App\AppCore\Domain\SaveDomainService;
use App\AppCore\Domain\SaveDomainServiceInterface;

/**
 * Class SaveApplication
 *
 * @package App\AppCore\Application
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
     * @var UploadedFileFactoryInterface
     */
    private $factory;
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
     * @param UploadedFileFactoryInterface $factory
     * @param SaveToFileSystemInterface    $saveToFileSystem
     * @param SaveDomainServiceInterface   $service
     */
    public function __construct(UploadedFileFactoryInterface $factory, SaveToFileSystemInterface $saveToFileSystem, SaveDomainServiceInterface $service)
    {
        $this->factory = $factory;
        $this->service = $service;
        $this->saveToFileSystem = $saveToFileSystem;
    }


    public function save(string $dir, string $file)
    {
        $this->saveToFileSystem->move($this->factory->createUploadedFile($file), $dir);
        $this->service->save($file);
    }
}
