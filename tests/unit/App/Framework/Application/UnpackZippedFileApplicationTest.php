<?php namespace App\Framework\Application;

use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\File;
use App\AppCore\Domain\Service\Files\Unpack;
use App\Framework\Service\Files\Params;
use App\Tests\unit\App\Framework\Application\UploadedFile;

class UnpackZippedFileApplicationTest extends \Codeception\Test\Unit
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
        $unpack = $this->make(Unpack::class, [
            'getTargetDir' => __DIR__,
            'unzip' => false,
        ]);
        $file = $this->make(File::class, [
            'isMimeTypeOf'=>true,
            'getBasenameWithoutExtension' => '',
        ]);
        $dir = $this->make(Dir::class);
        $unpacked_directory = '';
        $uploaded_directory = '';
        $application = new UnpackZippedFileApplication($unpack, $file, $dir, $unpacked_directory, $uploaded_directory);


        $application->unzipToTargetDir([
            'files' => $this->make(\Symfony\Component\HttpFoundation\File\UploadedFile::class, [
                'getClientOriginalName' => 'test'
            ]),
        ]);
        $uploadedFile = null;
    }
}
