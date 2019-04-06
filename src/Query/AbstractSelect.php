<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Selection\ArgumentToSelectionConverter;
use Happyr\DoctrineSpecification\Query\Selection\Selection;

abstract class AbstractSelect implements QueryModifier
{
    /**
     * @var Selection[]
     */
    private $selections;

    /**
     * @param mixed $field
     */
    public function __construct($field)
    {
        $this->selections = is_array($field) ? $field : func_get_args();
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $selections = [];
        foreach ($this->selections as $selection) {
            $selection = ArgumentToSelectionConverter::toSelection($selection);
            $selections[] = $selection->transform($qb, $dqlAlias);
        }

        $type = $this->getSelectType();
        $qb->$type($selections);
    }

    /**
     * Return a select type (ie a function of QueryBuilder) like: "select", "addSelect".
     *
     * @return string
     */
    abstract protected function getSelectType();
}
