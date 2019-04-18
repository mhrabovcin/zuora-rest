<?php

namespace Zuora\Test\Object;

use PHPUnit\Framework\TestCase;
use Zuora\Object\ZuoraObject;

class ZuoraObjectTest extends TestCase
{

    public function testObject()
    {
        $data = [
            'id' => md5(rand()),
            'name' => 'testname',
            'CustomField__c' => 'value',
        ];

        $object = new ZuoraObject($data);
        $this->assertEquals($object->id, $data['id']);
        $this->assertEquals($object->name, $data['name']);
        $this->assertEquals($object->getCustomField('CustomField'), $data['CustomField__c']);
        $this->assertEquals($object->getCustomField('CustomField__c'), $data['CustomField__c']);
    }

    /**
     * Test exception on non-existing array key
     *
     * @expectedException \InvalidArgumentException
     */
    public function testMapWrongArgument()
    {
        $data = [];
        $object = new ZuoraObject($data);
        $object->map('noexisting', '\Zuora\Object\ZuoraObject');
    }

    /**
     * Test exception on non-array key
     *
     * @expectedException \InvalidArgumentException
     */
    public function testdMapWrongArgumentType()
    {
        $data = ['scalar' => 'value'];
        $object = new ZuoraObject($data);
        $object->map('scalar', '\Zuora\Object\ZuoraObject');
    }

    /**
     * Test exception on non-array key
     *
     * @expectedException \InvalidArgumentException
     */
    public function testdMapWrongClassname()
    {
        $data = ['test' => []];
        $object = new ZuoraObject($data);
        $object->map('test', 'MissingClass');
    }
}
