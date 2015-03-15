<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class ResultModifierCollection implements ResultModifier
{
    /**
     * @var ResultModifier[]
     */
    private $children;

    /**
     * Construct it with one or more instances of ResultModifier.
     */
    public function __construct()
    {
        $this->children = func_get_args();
    }

    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        foreach ($this->children as $child) {
            if (!$child instanceof ResultModifier) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Child passed to ResultModifierCollection must be an instance of Happyr\DoctrineSpecification\Result\ResultModifier, but instance of %s found',
                        get_class($child)
                    )
                );
            }

            $child->modify($query);
        }
    }
}
