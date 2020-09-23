<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Service;

use App\AppCore\Domain\Repository\TestEntityInterface;

class UpdateTestService
{
    public function update(TestEntityInterface $test, array $data): TestEntityInterface
    {
        $test->setUuid($data['uuid']);
        $test->setUrl($data['url']);
        $test->setScript($data['script']);
        $test->setHeader($data['header']);
        $test->setBody($data['body']);
        $test->setRequestedBody($data['requestedBody']);
        return $test;
    }
}
