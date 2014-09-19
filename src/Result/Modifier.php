<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;

interface Modifier
{
    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query);
} 
