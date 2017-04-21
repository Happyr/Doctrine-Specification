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
    private $children;

    /**
     * Construct it with two or more instances of ResultModifier.
     *
     * @param ResultModifier $children1
     * @param ResultModifier $children2
     */
    public function __construct(ResultModifier $children1, ResultModifier $children2)
    {
        foreach (func_get_args() as $children) {
            $this->addChildren($children);
        }
    }

    /**
     * @param ResultModifier $children
     */
    public function addChildren(ResultModifier $children)
    {
        $this->children[] = $children;
    }

    /**
     * @return ResultModifier[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}
