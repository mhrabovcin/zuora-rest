<?php

namespace Zuora\Test;

use PHPUnit\Framework\TestCase;

class Base extends TestCase
{

    /**
     * Get test environment
     *
     * @param array $options
     *   (Optional) Override default test values
     *
     * @return \Zuora\Environment
     */
    protected function getEnvironment($options = [])
    {
        return \Zuora\Environment::factory($options + [
           'username' => 'first.last@example.com',
           'password' => 'password',
           'endpoint' => 'http://api.example.com/rest',
        ]);
    }

    /**
     * Call protected/private method of a class.
     *
     * Taken from:
     * https://jtreminio.com/2013/03/unit-testing-tutorial-part-3-testing-protected-private-methods-coverage-reports-and-crap/
     *
     * @param object $object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
