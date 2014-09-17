<?php


namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\LogicException;

/**
 * Class BaseSpecification
 *
 * Extend this abstract class if you want to build a new spec with your domain logic
 */
abstract class BaseSpecification implements Specification
{
    /**
     * @var Specification spec
     *
     */
    protected $spec;

    /**
     * @var string|null dqlAlias
     *
     */
    protected $dqlAlias;

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
    public function getExpression(QueryBuilder $qb, $dqlAlias)
    {
        $this->validateSpec();

        return $this->spec->getExpression($qb, $this->getAlias($dqlAlias));
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $this->validateSpec();

        $this->spec->modify($qb, $this->getAlias($dqlAlias));
    }

    /**
     * Make sure that the spec is a Specification
     *
     * @throws \LogicException
     */
    private function validateSpec()
    {
        if (!$this->spec instanceof Specification) {
            throw new LogicException(sprintf(
                'The protected variable BaseSpecification::spec must be an instance of Specification.
                Please validate the class %s and make sure to assign $this->spec with a object implementing %s.',
                get_class($this),
                'Happyr\DoctrineSpecification\Specification'
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
