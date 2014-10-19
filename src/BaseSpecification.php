<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\LogicException;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Query\QueryModifier;

/**
 * Extend this abstract class if you want to build a new spec with your domain logic
 */
abstract class BaseSpecification implements Specification
{
    /**
     * @var string|null dqlAlias
     */
    private $dqlAlias = null;

    /**
     * You may assign a Specification to this property. If you do, you do not *need* to overwrite the getFilterInstance
     * or getQueryModifierInstance
     *
     * @var Specification spec
     */
    protected $spec = null;

    /**
     * @param string $dqlAlias
     */
    public function __construct($dqlAlias = null)
    {
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * This method should return a Filter. You should overwrite this if you're not using BaseSpecification::$spec
     *
     * @return Filter
     */
    protected function getFilterInstance()
    {
        return $this->spec;
    }

    /**
     * This method should return a QueryModifier. You should overwrite this if you're not using BaseSpecification::$spec
     *
     * @return QueryModifier
     */
    protected function getQueryModifierInstance()
    {
        return $this->spec;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, $dqlAlias)
    {
        $this->validate('getFilterInstance', 'Happyr\DoctrineSpecification\Filter\Filter');

        if (null === $filter = $this->getFilterInstance()) {
            return;
        }

        return $filter->getFilter($qb, $this->getAlias($dqlAlias));
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $this->validate('getQueryModifierInstance', 'Happyr\DoctrineSpecification\Query\QueryModifier');

        if (null === $queryModifier = $this->getQueryModifierInstance()) {
            return;
        }

        $queryModifier->modify($qb, $this->getAlias($dqlAlias));
    }

    /**
     * @param string $getter
     * @param string $class
     *
     * @throws LogicException
     */
    private function validate($getter, $class)
    {
        $object = $this->$getter();
        // if $object is an object but not instance of $class
        if (!is_null($object) && !is_a($object, $class)) {
            throw new LogicException(sprintf(
                'Returned object must be an instance of %s. Please validate the %s::%s function and make it return instance of %s.',
                $class,
                get_class($this),
                $getter,
                $class
            ));
        }
    }

    /**
     * @param string $dqlAlias
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