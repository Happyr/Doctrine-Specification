<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 31/05/18
 * Time: 11:30
 */

namespace Happyr\DoctrineSpecification\Query;


use Doctrine\ORM\QueryBuilder;

class AddSelect implements QueryModifier
{
    private $alias;

    public function __construct($alias)
    {

        $this->alias = $alias;
    }

    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        // TODO: Implement modify() method.
        $qb->addSelect($this->alias);
    }

}