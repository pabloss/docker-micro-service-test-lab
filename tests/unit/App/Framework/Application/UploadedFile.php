<?php
declare(strict_types=1);

namespace App\Tests\unit\App\Framework\Application;

class UploadedFile extends \App\Framework\Service\Files\UploadedFile
{
    public static function nullForInstance()
    {
        self::$instance = null;
    }
}
