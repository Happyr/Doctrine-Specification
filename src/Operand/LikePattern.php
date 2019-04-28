<?php

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\ValueConverter;

class LikePattern implements Operand
{
    const CONTAINS = '%%%s%%';

    const ENDS_WITH = '%%%s';

    const STARTS_WITH = '%s%%';

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $format;

    /**
     * @param string $value
     * @param string $format
     */
    public function __construct($value, $format = self::CONTAINS)
    {
        $this->value = $value;
        $this->format = $format;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        $paramName = sprintf('comparison_%d', $qb->getParameters()->count());
        $value = ValueConverter::convertToDatabaseValue($this->value, $qb);
        $value = $this->formatValue($this->format, $value);
        $qb->setParameter($paramName, $value);

        return sprintf(':%s', $paramName);
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
