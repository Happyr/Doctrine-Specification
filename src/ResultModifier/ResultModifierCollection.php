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
    private $modifiers = [];

    /**
     * Construct it with two or more instances of ResultModifier.
     *
     * @param ResultModifier $modifier1
     * @param ResultModifier $modifier2
     */
    public function __construct(ResultModifier $modifier1, ResultModifier $modifier2)
    {
        foreach (func_get_args() as $modifier) {
            $this->addModifier($modifier);
        }
    }

    /**
     * @param ResultModifier $modifier
     */
    public function addModifier(ResultModifier $modifier)
    {
        $this->modifiers[] = $modifier;
    }

    /**
     * @return ResultModifier[]
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }
}
