<?php

namespace Happyr\DoctrineSpecification\Filter;

class Like extends Comparison
{
    const CONTAINS = '%%%s%%';

    const ENDS_WITH = '%%%s';

    const STARTS_WITH = '%s%%';

    /**
     * @param string $field
     * @param string $value
     * @param string $format
     * @param string $dqlAlias
     */
    public function __construct($field, $value, $format = self::CONTAINS, $dqlAlias = null)
    {
        $formattedValue = $this->formatValue($format, $value);
        parent::__construct(self::LIKE, $field, $formattedValue, $dqlAlias);
    }

    /**
     * @param string $format
     * @param string $value
     *
     * @return string
     */
    private function formatValue($format, $value)
    {
        return sprintf($format, $value);
    }
}
