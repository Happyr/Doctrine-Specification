<?php


namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use LogicException;

/**
 * Class BaseSpecification
 *
 * Extend this abstract class if you want to build a new spec with your domain logic
 *
 * @author Tobias Nyholm
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
     * @param string $dqlAlias
     *
     * @return Expr
     * @throws LogicException
     */
    public function match(QueryBuilder $qb, $dqlAlias)
    {
        $this->validateSpec();

        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        return $this->spec->match($qb, $dqlAlias);
    }

    /**
     * Make sure that the spec is a Specification
     *
     * @throws LogicException
     */
    private function validateSpec()
    {
        if (!$this->spec instanceof Specification) {
            throw new LogicException(sprintf(
                'The protected variable BaseSpecification::spec must be an instance of Specification. Please validate the class %s and make sure to assign $this->spec with a object implementing %s.',
                get_class($this),
                'Happyr\DoctrineSpecification\Specification'
            ));
        }
    }
}