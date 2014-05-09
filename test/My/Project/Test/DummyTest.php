<?php

namespace My\Project\Test;

use My\Project\ZuoraRest;

class DummyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A dummy test that calls a beacon method ensuring the class is autolaoded.
     *
     * @see https://github.com/cpliakas/php-project-starter/issues/19
     * @see https://github.com/cpliakas/php-project-starter/issues/21
     */
    public function testAutoload()
    {
        $class = new ZuoraRest();
        $this->assertTrue($class->autoloaded());
    }
}
