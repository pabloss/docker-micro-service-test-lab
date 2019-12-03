<?php namespace Files;

use App\Framework\Service\Files\Params;
use App\Framework\Service\Files\UploadedFile;
use Codeception\Stub;
use Symfony\Component\HttpFoundation\File\UploadedFile as BaseUploadedFile;

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
    public function testGetUniqueFileName()
    {
        $fileName = 'test';
        $extension = 'xxxffff';

        /** @var BaseUploadedFile $baseUploadedFile */
        $baseUploadedFile = Stub::make(BaseUploadedFile::class, [
            'getClientOriginalName' => $fileName,
            'getExtension' => $extension,
        ]);
        $uploadedFile = UploadedFile::instance(Params::getInstance('', $baseUploadedFile));

        self::assertStringStartsWith($fileName, $uploadedFile->getUniqueFileName());
        self::assertRegExp("/$extension$/", $uploadedFile->getUniqueFileName());
    }

    // tests
    public function testGetUniqueFileNameWhenNameIsNotASCII()
    {
        $fileName = 'test-';
        $extension = 'xxxffff';

        /** @var BaseUploadedFile $baseUploadedFile */
        $baseUploadedFile = Stub::make(BaseUploadedFile::class, [
            'getClientOriginalName' => $fileName,
            'getExtension' => $extension,
        ]);
        $uploadedFile = UploadedFile::instance(Params::getInstance('', $baseUploadedFile));

        self::assertStringStartsWith(
            transliterator_transliterate(
                'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                $fileName
            ),
            $uploadedFile->getUniqueFileName());
        self::assertRegExp("/$extension$/", $uploadedFile->getUniqueFileName());
    }
}
