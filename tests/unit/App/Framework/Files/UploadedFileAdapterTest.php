<?php

namespace App\Framework\Files;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileAdapterTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testGetBasename()
    {
        // mam wykorzystać framework - czyli jednak integracyjny
        $path = __DIR__ . '/../../../../_data/save_test'; //do integracyjhnego
        $originalFileName = basename($path);

        $adapter = new UploadedFileAdapter(new UploadedFile($path, $originalFileName));

        $this->tester->assertEquals($originalFileName, $adapter->getBasename());
    }
}
