<?php
declare(strict_types=1);

namespace App\AppCore\Application\Save;

use App\AppCore\Domain\Actors\FileInterface;
use App\AppCore\Domain\Service\Save\SaveDomainService;
use App\AppCore\Domain\Service\Save\SaveDomainServiceInterface;
use DateTime;

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
     * @param SaveToFileSystemInterface  $saveToFileSystem
     * @param SaveDomainServiceInterface $service
     */
    public function __construct(SaveToFileSystemInterface $saveToFileSystem, SaveDomainServiceInterface $service)
    {
        $this->service = $service;
        $this->saveToFileSystem = $saveToFileSystem;
    }


    public function save(string $dir, FileInterface $file, DateTime $when)
    {
        $this->service->save($this->saveToFileSystem->move($dir, $file, $when)->getPath());
    }
}
