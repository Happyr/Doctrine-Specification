<?php

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class ResultModifierCollection implements ResultModifier
{
    /**
     * @var ResultModifier[]
     */
    private $children;

    /**
     * @param ResultModifier $child
     */
    function __construct(ResultModifier $child)
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
                        'Child passed to ModifierCollection must be an instance of Result\Modifier, but instance of %s found',
                        get_class($child)
                    )
                );
            }

            $child->modify($query);
        }
    }
}
