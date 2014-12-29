<?php

namespace Happyr\DoctrineSpecification;

class ParametersBag
{
    /**
     * @var array DQL Parameters array
     */
    private $parameters = [];

    /**
     * Clears parameters array
     */
    public function clear()
    {
        $this->parameters = [];
    }

    /**
     * Returns parameters array
     *
     * @return array
     */
    public function get()
    {
        return $this->parameters;
    }

    /**
     * Add new parameter to collection and returns it's name
     *
     * @param $value mixed parameter value
     *
     * @return string DQL Parameter name
     */
    public function add($value)
    {
        $key = count($this->parameters) + 1;
        $this->parameters[$key] = $value;

        return '?' . $key;
    }

    /**
     * Checks whether the parameters array is non empty
     *
     * @return bool
     */
    public function has()
    {
        return (boolean)count($this->parameters);
    }
}
