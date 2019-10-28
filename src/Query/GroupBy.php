<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Alias;
use Happyr\DoctrineSpecification\Operand\Field;

class GroupBy implements QueryModifier
{
    /**
     * @var Field|Alias
     */
    protected $field;

    /**
     * @var string|null
     */
    protected $dqlAlias;

    /**
     * @param Field|Alias|string $field
     * @param string|null        $dqlAlias
     */
    public function __construct($field, $dqlAlias = null)
    {
        if (!($field instanceof Field) && !($field instanceof Alias)) {
            $field = new Field($field);
        }

        $this->field = $field;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if ($this->dqlAlias !== null) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->addGroupBy($this->field->transform($qb, $dqlAlias));
    }
}
