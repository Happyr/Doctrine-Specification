<?php

namespace Happyr\DoctrineSpecification\ResultModifier;

use Doctrine\ORM\AbstractQuery;

interface ResultModifier
{
    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query);
}
