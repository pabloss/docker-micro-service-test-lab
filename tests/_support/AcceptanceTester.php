<?php

use App\AppCore\Domain\Service\Command\CommandProcessor;
use App\AppCore\Domain\Service\Files\Dir;
use App\AppCore\Domain\Service\Files\Unpack;
use Codeception\Scenario;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    const TEST_UPLOADED_DIR = "files/";
    const DATA_DIR = __DIR__ . '/../_data/';
    const TEST_DOCKER_IMAGE = 'bulletinboard:1.0';
    const TEST_DOCKER_CONTAINER_SEARCH = "docker ps -a | grep '".self::TEST_DOCKER_IMAGE."' | awk '{print $1}'";
    const UNPACKED_TARGET_DIR = self::DATA_DIR . 'unpacked/test/';

    use _generated\AcceptanceTesterActions;

    /** @var string */
    private $filePath;
    private $proc_open;
    private $pipes;
    private $zip;

    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);
        $this->zip = new ZipArchive();
    }

    /**
     * @Given I have :filename path
     * @param $filename
     */
    public function iHavePath($filename)
    {
        Codeception\PHPUnit\TestCase::assertFileExists(self::DATA_DIR . $filename);
        $this->filePath = self::DATA_DIR . $filename;
    }

    /**
     * @When I unpack it to :toDirPath path
     * @param $toDirPath
     */
    public function iUnpackItToPath($toDirPath)
    {
        $service = new Unpack();
        $dirService = new Dir();
        $dirService->sureTargetDirExists( self::DATA_DIR .$toDirPath);
        $service->unzip($this->filePath, self::DATA_DIR .$toDirPath);
    }

    /**
     * @Then :dirName dir is created
     * @param $dirName
     */
    public function dirIsCreated($dirName)
    {
        $this->assertTrue(file_exists(self::DATA_DIR . $dirName));
        $this->assertTrue(is_dir(self::DATA_DIR . $dirName));
    }

    /**
     * @Then content of unzipped :zipFilePath and :unzippedFilePath are the same
     * @param $zipFilePath
     * @param $unzippedFilePath
     *
     * @after checkDirs
     */
    public function contentOfUnzippedAndAreTheSame($zipFilePath, $unzippedFilePath)
    {
        // unpack it in test, scan target dir and compare unzippedFileName contents
        if ($this->zip->open(self::DATA_DIR .$zipFilePath) === true) {
            $this->assertEquals($this->zip->numFiles, count($this->getUnzippedDirContent($unzippedFilePath)));
            foreach ($this->getUnzippedDirContent($unzippedFilePath) as $unzippedFileName) {
                for($i = 0; $i < $this->zip->numFiles; $i++) {
                    if($unzippedFileName === $this->getInternalUnzippedFile($i)){
                        $this->assertEquals(sha1_file(self::UNPACKED_TARGET_DIR .$unzippedFileName), sha1_file(self::UNPACKED_TARGET_DIR . $this->zip->getNameIndex($i)));
                    }
                }
            }
            $this->zip->close();
        }
        $this->docker();
        $this->dir(self::DATA_DIR . 'unpacked/');
    }

    /**
     * @Given I have :filename file
     * @param $filename
     */
    public function iHaveFile($filename)
    {
        Codeception\PHPUnit\TestCase::assertFileExists(self::DATA_DIR . $filename);
    }

    /**
     * @before checkDirs
     *
     * @When I upload :filename file
     * @param $filename
     */
    public function iUploadFile($filename)
    {
        $this->amOnPage("/");
        $this->attachFile('input[type="file"]', $filename);
    }

    /**
     * @before checkDirs
     * @after checkDirs
     *
     * @Then I can find file that name starts with :prefix in :uploadDir location
     * @param $prefix
     * @param $uploadDir
     */
    public function iCanFindFileThatNameStartsWithInLocation($prefix, $uploadDir)
    {
        $this->wait(5);
        Codeception\PHPUnit\TestCase::assertStringStartsWith($prefix, $this->getLastFileName($uploadDir));
        // clenup docker
        $this->docker();
        $this->checkDirs();
    }

    /**
     * @param string $subDir
     * @return mixed
     */
    private function getLastFileName(string $subDir)
    {
        return array_diff(scandir(self::TEST_UPLOADED_DIR . $subDir, SCANDIR_SORT_DESCENDING), ['..', '.', '.gitkeep'])[0];
    }

    /**
     * @Then I see uploaded and unpacked file in :uploadedDir dir
     * @param string $unpackedDir
     */
    public function iSeeUploadedAndUnpackedFileInDir(string $unpackedDir)
    {
        $this->seeFileFound(self::TEST_UPLOADED_DIR . $unpackedDir.'/'.$this->getBasenameWithoutExtension($this->getLastFileName($unpackedDir)));
    }

    /**
     * @param string $filePath
     * @return string
     */
    private function getBasenameWithoutExtension(string $filePath): string
    {
        return \basename($filePath, '.' . $this->getExtension($filePath));
    }

    /**
     * @param string $filePath
     * @return mixed
     */
    private function getExtension(string $filePath)
    {
        return \pathinfo($filePath)['extension'] ?? '';
    }


    /**
     * @param $arg1
     * @todo change name of arg1
     * @When I deploy file in :arg1 dir
     */
    public function iDeployFileInDir($arg1)
    {
        $this->wait(5);
        flush();
        // run  docker
        $this->proc_open = proc_open(
            " docker-compose -f " .
            self::TEST_UPLOADED_DIR . 'unpacked/'.$this->getBasenameWithoutExtension($this->getLastFileName('unpacked'))."/micro-service-1/" .
            "docker-compose.yml".
            "   up -d --force-recreate" .
            " 2>&1",
            CommandProcessor::DESCRIPTOR_SPECS,
            $this->pipes,
            realpath('./'),
            []
        );
    }

    /**
     * @after checkDirs
     * @Then I see deploy process in console
     */
    public function iSeeDeployProcessInConsole()
    {
        if (is_resource($this->proc_open)) {
            $i = 0;
            while (($s = fgets($this->pipes[1]))) {
                if(empty(\trim($s))){
                    continue;
                }
                $this->assertIsString($s) ;
                $this->assertNotEmpty($s) ;
                $this->assertStringNotContainsString("does not exist", $s) ;
                $this->assertStringNotContainsString("missing", $s) ;
                $this->assertStringNotContainsString("requires at least", $s) ;

                flush();
                $i++;
            }
            if(0 === $i){
                $this->fail("0 spins of loop");
            }
        }
        // clenup docker
        $this->docker();
        $this->checkDirs();
    }

    /**
     * @todo a może raz check Dir albo wcale by robiła to apka
     */
    protected function checkDirs()
    {
        $this->dir(self::TEST_UPLOADED_DIR . 'uploaded/');
        $this->dir(self::TEST_UPLOADED_DIR . 'unpacked/');
    }

    /**
     * @param $unzippedFilePath
     * @return array
     */
    protected function getUnzippedDirContent($unzippedFilePath): array
    {
        return array_diff(scandir(self::DATA_DIR . $unzippedFilePath), ['..', '.']);
    }

    /**
     * @param int $i
     * @return false|string
     */
    protected function getInternalUnzippedFile(int $i)
    {
        return $this->zip->getNameIndex($i);
    }
}
