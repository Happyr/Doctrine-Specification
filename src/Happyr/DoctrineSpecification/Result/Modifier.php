<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\Query;

interface Modifier
{
    /**
     * @param Query $query
     */
    public function modify(Query $query);
} 
