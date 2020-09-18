<?php
declare(strict_types=1);

namespace App\AppCore\Domain\Actors;

interface StatusEntityInterface
{
public function asArray();
public function getCreated();
public function getId();
public function getStatusName();
public function getUService();
public function getUuid();
}
