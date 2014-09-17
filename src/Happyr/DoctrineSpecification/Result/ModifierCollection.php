<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class ModifierCollection implements Modifier
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
     * @param Query $query
     */
    public function modify(Query $query)
    {
        foreach ($this->children as $child) {
            if (!$child instanceof Modifier) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Child passed to ModifierCollection must be an instance of Result\Modifier, but instance of %s found',
                        get_class($child)
                    )
                );
            }

            $child->modify($query);
        }
    }
}
