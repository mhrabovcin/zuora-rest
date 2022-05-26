<?php

namespace Zuora\Object;

class ZuoraObject
{
    /**
     * Data retrieved from API response
     *
     * @var array
     */
    protected $data;

    /**
     * Hold mapped objects
     *
     * @var array
     */
    protected $mapped = [];


    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Override magic __get to read property access from data array.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }


    /**
     * Retrieve custom field from object. Its enough to pass field name without __c suffix.
     *
     * @param string $name
     *
     * @return string
     */
    public function getCustomField($name)
    {
        if (strpos($name, '__c') != strlen($name) - 3) {
            $name .= '__c';
        }
        return $this->{$name};
    }


    /**
     * Map data properties to class.
     *
     * @param string $property
     *   Name of property in data array.
     *
     * @param string $classname
     *   Name of class that data should be mapped to
     *
     * @param string|null $key
     *   Optionally array data key that should be used for mapping.
     *
     * @return array
     *   Mapped objects to array
     *
     * @throws \InvalidArgumentException
     *   If $property does not exists in data array
     */
    public function map($property, $classname)
    {
        if (!isset($this->mapped[$property])) {
            $this->mapped[$property] = [];

            if (!isset($this->data[$property])) {
                throw new \InvalidArgumentException("{$property} doesn't exists.");
            }

            if (!is_array($this->data[$property])) {
                throw new \InvalidArgumentException("{$property} isn't array.");
            }

            if (!class_exists($classname)) {
                throw new \InvalidArgumentException("{$classname} isn't valid name of PHP class.");
            }

            $objects = [];

            foreach ($this->data[$property] as $record) {
                $objects[] = new $classname($record);
            }

            $this->mapped[$property] = $objects;
        }

        return $this->mapped[$property];
    }
}
