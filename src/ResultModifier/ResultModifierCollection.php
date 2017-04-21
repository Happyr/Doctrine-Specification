<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\ResultModifier;

class ResultModifierCollection implements ResultModifier
{
    /**
     * @var ResultModifier[]
     */
    private $children = [];

    /**
     * Construct it with two or more instances of ResultModifier.
     *
     * @param ResultModifier $child1
     * @param ResultModifier $child2
     */
    public function __construct(ResultModifier $child1, ResultModifier $child2)
    {
        foreach (func_get_args() as $child) {
            $this->addChild($child);
        }
    }

    /**
     * @param ResultModifier $child
     */
    public function addChild(ResultModifier $child)
    {
        $this->children[] = $child;
    }

    /**
     * @return ResultModifier[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}
