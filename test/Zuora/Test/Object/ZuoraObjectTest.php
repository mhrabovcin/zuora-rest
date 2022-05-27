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
     */
    public function testMapWrongArgument()
    {
        $this->expectException(\InvalidArgumentException::class);

        $data = [];
        $object = new ZuoraObject($data);
        $object->map('noexisting', '\Zuora\Object\ZuoraObject');
    }

    /**
     * Test exception on non-array key
     */
    public function testMapWrongArgumentType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $data = ['scalar' => 'value'];
        $object = new ZuoraObject($data);
        $object->map('scalar', '\Zuora\Object\ZuoraObject');
    }

    /**
     * Test exception on non-array key
     */
    public function testMapWrongClassname()
    {
        $this->expectException(\InvalidArgumentException::class);

        $data = ['test' => []];
        $object = new ZuoraObject($data);
        $object->map('test', 'MissingClass');
    }
}
