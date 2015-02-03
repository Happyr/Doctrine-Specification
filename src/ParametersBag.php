<?php

namespace Happyr\DoctrineSpecification;

class ParametersBag
{
    /**
     * @var array DQL Parameters array
     */
    private $parameters = [];

    /**
     * @var string
     */
    private $lastName = '';

    /**
     * Clears parameters array
     */
    public function clearAll()
    {
        $this->parameters = [];
    }

    /**
     * Returns parameters array
     *
     * @return array
     */
    public function getAll()
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

        $this->lastName = '?' . $key;
    }

    /**
     * Checks whether the parameters array is non empty
     *
     * @return bool
     */
    public function hasAny()
    {
        return (boolean)count($this->parameters);
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}
