<?php 

class DeployServiceCest
{
    const TEST_UPLOADED_DIR = "/../../files/";
    const DATA_DIR =   '/../_data/';
    const TEST_UPLOAD_FILE_NAME = 'test.upload';
    const PACKED_MICRO_SERVICE = 'packed/scratch.zip';
    const ZIPPED_TEST_UPLOAD_FILE_NAME = 'test.zip';
    const UNPACKED = 'unpacked';
    const MICRO_SERVICE_1_DOCKERFILE = 'scratch/Dockerfile';

    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $imagePrefix = 'image_prefix';
        $containerPrefix = 'container_prefix';

        $data = [];
        exec("docker ps --filter 'name=test_container' --format '{{.ID}}'", $data, $resultCode);
        if(!empty($data)){
            $I->runShellCommand("docker rm  $(docker ps --filter 'name={$containerPrefix}' --format '{{.ID}}' -a) -f", false);
        }
        $data = [];
        exec("docker images 'test_image*' --format '{{.ID}}'", $data, $resultCode);
        if(!empty($data)){
            $I->runShellCommand("docker rmi $(docker images '{$imagePrefix}*' --format '{{.ID}}') -f", false);
        }
        
        $I->amOnPage("/");
        $I->attachFile('input[type="file"]', self::DATA_DIR. self::PACKED_MICRO_SERVICE);
        $I->wait(5);
        Codeception\PHPUnit\TestCase::assertStringStartsWith("scratch.zip", $this->getLastFileName('uploaded/'));
        $I->click('button#deploy');

        // asercje
        /**
         * 1. jeśli wyślę zipa z dockerem na /upload
         * 2. a potem kliknę deploy
         * 3. to zip z dockerem ma się rozpakować
         * 4. nadać nazwę obrazowi
         * 5. nadać nazwę kontenerowi
         *
         */$I->wait(10);
        $I->assertFileExists(__DIR__. self::TEST_UPLOADED_DIR.'unpacked/'.self::TEST_UPLOAD_FILE_NAME);
        $I->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerPrefix' --format '{{.Names}}')", false);
        $I->seeInShellOutput('true'); ///-- DZIAŁA!!!
        $I->runShellCommand("docker inspect -f '{{.State.Running}}' $(docker ps --filter 'name=$containerPrefix' --format '{{.Names}}' -a) | wc -l", false);
        $I->seeInShellOutput('1'); ///-- DZIAŁA!!!
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
