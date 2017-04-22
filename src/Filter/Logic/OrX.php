<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Filter\Logic;


use Happyr\DoctrineSpecification\Filter\Filter;

class OrX implements Filter
{
    /**
     * @var Filter[]
     */
    private $filters;

    /**
     * Construct it with two or more instances of Specification.
     *
     * @param Filter $filter1
     * @param Filter $filter2
     */
    public function __construct(Filter $filter1, Filter $filter2)
    {
        foreach (func_get_args() as $filter) {
            $this->orX($filter);
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
     * @param Filter $filter
     */
    public function orX(Filter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * @return Filter[]
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
