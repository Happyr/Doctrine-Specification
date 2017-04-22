<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\QueryModifier;

class QueryModifierCollection implements QueryModifier
{
    /**
     * @var QueryModifier[]
     */
    private $modifiers;

    /**
     * Construct it with two or more instances of QueryModifier.
     *
     * @param QueryModifier $modifier1
     * @param QueryModifier $modifier2
     */
    public function __construct(QueryModifier $modifier1, QueryModifier $modifier2)
    {
        foreach (func_get_args() as $modifier) {
            $this->addModifier($modifier);
        }
    }

    /**
     * @param QueryModifier $modifier
     */
    public function addModifier(QueryModifier $modifier)
    {
        $this->modifiers[] = $modifier;
    }

    /**
     * @return QueryModifier[]
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }
}
