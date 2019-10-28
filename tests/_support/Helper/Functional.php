<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use App\Tests\_support\Helper\Recovery;

class Functional extends \Codeception\Module
{
    use Recovery;
}
