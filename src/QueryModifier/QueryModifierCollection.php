<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\QueryModifier;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;

class QueryModifierCollection implements QueryModifier
{
    /**
     * @var QueryModifier[]
     */
    private $children;

    /**
     * Construct it with one or more instances of QueryModifier.
     */
    public function __construct()
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
            if (!$child instanceof QueryModifier) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Child passed to QueryModifierCollection must be an instance of Happyr\DoctrineSpecification\QueryModifier\QueryModifier, but instance of %s found',
                        get_class($child)
                    )
                );
            }

            $child->modify($qb, $dqlAlias);
        }
    }
}
