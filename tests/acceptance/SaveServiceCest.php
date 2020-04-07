<?php 

class SaveServiceCest
{
    const TEST_UPLOADED_DIR = "/../../files/";
    const DATA_DIR =   '/../_data/';
    const TEST_UPLOAD_FILE_NAME = 'test.upload';

    public function _before(AcceptanceTester $I)
    {
    }
    public function _after(AcceptanceTester $I)
    {
        file_put_contents(__DIR__.self::DATA_DIR. self::TEST_UPLOAD_FILE_NAME, '');
//        $files = array_diff(scandir(__DIR__.self::TEST_UPLOADED_DIR.'uploaded/' , SCANDIR_SORT_DESCENDING), ['..', '.', '.gitkeep']);
//        foreach ($files as $file) {
//            unlink(__DIR__.self::TEST_UPLOADED_DIR.'uploaded/'.$file);
//        }
    }


    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage("/");
        $I->attachFile('input[type="file"]', self::DATA_DIR. self::TEST_UPLOAD_FILE_NAME);
        $I->wait(5);
        Codeception\PHPUnit\TestCase::assertStringStartsWith("test", $this->getLastFileName('uploaded/'));
        $id = $I->grabFromDatabase('u_service', 'id', [
            'file' => \basename(__DIR__.self::TEST_UPLOADED_DIR.self::TEST_UPLOAD_FILE_NAME),
        ]);
        $I->seeInDatabase('u_service',
            [
                'file' => \basename(__DIR__.self::TEST_UPLOADED_DIR.self::TEST_UPLOAD_FILE_NAME),
                'moved_to_dir' => \basename(__DIR__.self::TEST_UPLOADED_DIR.'/uploaded'). $id
            ]
        );
    }

    private function getLastFileName(string $subDir)
    {
        return array_diff(scandir(__DIR__.self::TEST_UPLOADED_DIR.$subDir , SCANDIR_SORT_DESCENDING), ['..', '.', '.gitkeep'])[0];
    }
}
