<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\Specification;

class OrX implements Specification
{
    /**
     * @var Specification[]
     */
    private $children;

    /**
     * Construct it with two or more instances of Specification.
     *
     * @param Specification $child1
     * @param Specification $child2
     */
    public function __construct(Specification $child1, Specification $child2)
    {
        foreach (func_get_args() as $child) {
            $this->orX($child);
        }
    }

    /**
     * Append an other specification with a logic OR.
     *
     * <code>
     * $spec = Spec::orX(A, B);
     * $spec->orX(C);
     *
     * // We be the same as
     * $spec = Spec::orX(A, B, C);
     * </code>
     *
     * @param Specification $child
     */
    public function orX(Specification $child)
    {
        $this->children[] = $child;
    }

    /**
     * @return Specification[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}
