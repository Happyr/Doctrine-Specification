<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class OptionCollection implements Modifier
{
    /**
     * @var Modifier[]
     */
    private $children;

    /**
     * @param Modifier $child
     */
    function __construct(Modifier $child)
    {
        $this->children = func_get_args();
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        foreach ($this->children as $child) {
            if (!$child instanceof Modifier) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Child passed to ModifierCollection must be an instance of Query\Modifier, but instance of %s found',
                        get_class($child)
                    )
                );
            }

            $child->modify($qb, $dqlAlias);
        }
    }
}
