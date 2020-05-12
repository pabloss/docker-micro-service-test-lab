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
    }


    // tests
    public function tryToTest(AcceptanceTester $I)
    {

        $beforeCount = $I->grabNumRecords('u_service');
        $I->amOnPage("/");
        $I->attachFile('input[type="file"]', self::DATA_DIR. self::TEST_UPLOAD_FILE_NAME);
        $I->wait(5);
        Codeception\PHPUnit\TestCase::assertStringStartsWith("test", $this->getLastFileName('uploaded/'));
        $afterCount =  $I->grabNumRecords('u_service');
        $ids = $I->grabColumnFromDatabase('u_service', 'id');
        $lastId = \end($ids);
        $I->assertEquals(1, $afterCount - $beforeCount);
        $I->seeInDatabase('u_service', [
            'id' => (int) $lastId,
            'moved_to_dir' => dirname(__DIR__).'/files/uploaded',
        ]);

    }

    private function getLastFileName(string $subDir)
    {
        return
            array_diff(
                scandir(__DIR__ . self::TEST_UPLOADED_DIR . $subDir .
                    array_diff(
                        scandir(__DIR__ . self::TEST_UPLOADED_DIR . $subDir,SCANDIR_SORT_DESCENDING),
                        ['..', '.', '.gitkeep']
                    )[0],SCANDIR_SORT_DESCENDING
                ),
                ['..', '.', '.gitkeep']
            )[0];
    }
}
