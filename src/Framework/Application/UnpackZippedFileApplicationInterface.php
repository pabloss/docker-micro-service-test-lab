<?php
declare(strict_types=1);

namespace App\Framework\Application;

use App\AppCore\Domain\Application\Stages\Unpack\UnzippedFileParamsInterface;

interface UnpackZippedFileApplicationInterface
{
    public function unzipToTargetDir(array $filesBag): UnzippedFileParamsInterface;
}