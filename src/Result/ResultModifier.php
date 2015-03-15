<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;

interface ResultModifier
{
    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query);
}
