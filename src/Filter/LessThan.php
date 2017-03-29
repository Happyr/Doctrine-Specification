<?php

namespace Happyr\DoctrineSpecification\Filter;

class LessThan extends Comparison
{
    /**
     * @param string $field
     * @param string $value
     * @param string $dqlAlias
     */
    public function __construct($field, $value, $dqlAlias = null)
    {
        parent::__construct(self::LT, $field, $value, $dqlAlias);
    }
}
