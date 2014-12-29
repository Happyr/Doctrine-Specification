<?php

namespace Happyr\DoctrineSpecification;

class ParametersBag
{
    private $parameters = [];

    public function clear()
    {
        $this->parameters = [];
    }

    public function get()
    {
        return $this->parameters;
    }

    public function add($value)
    {
        $key = count($this->parameters) + 1;
        $this->parameters[$key] = $value;

        return '?' . $key;
    }

    public function has()
    {
        return (boolean)count($this->parameters);
    }
}
