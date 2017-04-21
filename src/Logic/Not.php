<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Logic;

use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Specification;

class Not implements Specification
{
    /**
     * @var Filter
     */
    private $child;

    /**
     * @param Filter $expr
     */
    public function __construct(Filter $expr)
    {
        $this->child = $expr;
    }

    /**
     * @return Filter
     */
    public function getChild()
    {
        return $this->child;
    }
}
