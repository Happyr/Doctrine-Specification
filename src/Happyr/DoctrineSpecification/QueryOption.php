<?php

namespace Happyr\DoctrineSpecification;

use Doctrine\ORM\Query;

interface QueryOption
{
    /**
     * @param Query $query
     */
    public function modifyQuery(Query $query);
}