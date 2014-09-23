<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;

interface ResultModifier
{
    /**
     * @param AbstractQuery $query
     * @return void
     */
    public function modify(AbstractQuery $query);
} 
