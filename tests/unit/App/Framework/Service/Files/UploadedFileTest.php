<?php
namespace App\Framework\Service\Files;

use App\Tests\unit\App\Framework\Application\UploadedFile;
use Codeception\Stub\Expected;
use Symfony\Component\HttpFoundation\File\File;

class UploadedFileTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        UploadedFile::nullForInstance();
        $file = $this->make(File::class);
        $uploadedFile = $this->make(\Symfony\Component\HttpFoundation\File\UploadedFile::class, ['move' => $file]);
        $params = $this->make(Params::class, ['getUploadedFile' => $uploadedFile, 'getTargetDir' => '']);
        $service = UploadedFile::instance($params);
        $service->move('', '');
    }
}
