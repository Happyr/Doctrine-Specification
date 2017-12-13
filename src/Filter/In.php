<?php

namespace Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\ValueConverter;

class In implements Filter
{
    /**
     * @var string field
     */
    protected $field;

    /**
     * @var mixed value
     */
    protected $value;

    /**
     * @var string dqlAlias
     */
    protected $dqlAlias;

    /**
     * Make sure the $field has a value equals to $value.
     *
     * @param string $field
     * @param mixed  $value
     * @param string $dqlAlias
     */
    public function __construct($field, $value, $dqlAlias = null)
    {
        $this->field = $field;
        $this->value = $value;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        $value = $this->value;
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = ValueConverter::convertToDatabaseValue($v, $qb);
            }
        } else {
            $value = ValueConverter::convertToDatabaseValue($value, $qb);
        }

        $paramName = $this->getParameterName($qb);
        $qb->setParameter($paramName, $value);

        return (string) $qb->expr()->in(
            sprintf('%s.%s', $dqlAlias, $this->field),
            sprintf(':%s', $paramName)
        );
    }

    /**
     * Get a good unique parameter name.
     *
     * @param QueryBuilder $qb
     *
     * @return string
     */
    protected function getParameterName(QueryBuilder $qb)
    {
        return sprintf('in_%d', $qb->getParameters()->count());
    }
}
