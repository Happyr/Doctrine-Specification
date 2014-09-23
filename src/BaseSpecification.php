<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\LogicException;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\Modifier;

/**
 * Extend this abstract class if you want to build a new spec with your domain logic
 */
abstract class BaseSpecification implements Specification
{
    /**
     * @return Filter
     */
    abstract public function getWrappedExpression();

    /**
     * @return Modifier
     */
    abstract public function getWrappedModifier();

    /**
     * @var string|null dqlAlias
     */
    private $dqlAlias = null;

    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias = null)
    {
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
        $this->validate('getWrappedExpression', 'Happyr\DoctrineSpecification\Filter\Expression');

        return $this->getWrappedExpression()->getFilter($qb, $this->getAlias($dqlAlias));
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $this->validate('getWrappedModifier', 'Happyr\DoctrineSpecification\Query\Modifier');

        $this->getWrappedModifier()->modify($qb, $this->getAlias($dqlAlias));
    }

    /**
     * @param $getter
     * @param $class
     *
     * @throws LogicException
     */
    private function validate($getter, $class)
    {
        if (!is_a($this->$getter(), $class)) {
            throw new LogicException(sprintf(
                'Returned object must be an instance of %s.
                Please validate the %s::%s function and make it return instance of %s.',
                $class,
                get_class($this),
                $getter,
                $class
            ));
        }
    }

    /**
     * @param $dqlAlias
     *
     * @return string
     */
    private function getAlias($dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            return $this->dqlAlias;
        }

        return $dqlAlias;
    }
}
