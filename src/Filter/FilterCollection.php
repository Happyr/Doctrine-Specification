<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Filter;

class FilterCollection implements Filter
{
    /**
     * @var Filter[]
     */
    private $filters;

    /**
     * Construct it with two or more instances of Filter.
     *
     * @param Filter $filter1
     * @param Filter $filter2
     */
    public function __construct(Filter $filter1, Filter $filter2)
    {
        foreach (func_get_args() as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * @param Filter $filter
     */
    public function addFilter(Filter $filter)
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
