<?php

namespace Happyr\DoctrineSpecification\Where\Logic;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Where\Expression;

/**
 * Abstract Class LogicX
 *
 * This class should be used when you combine two specifications
 *
 * @author Tobias Nyholm
 * @author Benjamin Eberlei
 */
class LogicX implements Expression
{
    const AND_X = 'andX';
    const OR_X = 'orX';

    /**
     * @var Expression[] children
     */
    private $children;

    /**
     * @var string
     */
    private $expression;

    /**
     * Take two or more WhereSpecification as parameters
     *
     * @param string $expression
     * @param array $children
     *
     */
    public function __construct($expression, array $children)
    {
        $this->validateChildren($children);

        $this->expression = $expression;
        $this->children = $children;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr|mixed
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return call_user_func_array(
            array($qb->expr(), $this->expression),
            array_map(
                function (Expression $spec) use ($qb, $dqlAlias) {
                    return $spec->match($qb, $dqlAlias);
                },
                $this->children
            )
        );
    }

    /**
     * @param array $children
     *
     * @throws InvalidArgumentException
     */
    public function validateChildren(array $children)
    {
        foreach ($children as $child) {
            if (!$child instanceof Expression) {
                throw new InvalidArgumentException(
                    sprintf('Expected instance of "WhereSpecification" but got "%s"', get_class($child))
                );
            }
        }
    }
}
