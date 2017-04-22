<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\QueryModifier;

use Happyr\DoctrineSpecification\Filter\Filter;

class Having implements QueryModifier
{
    /**
     * @var Filter child
     */
    private $filter;

    /**
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
