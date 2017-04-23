<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\ResultManagement;

use Happyr\DoctrineSpecification\Specification;

class Slice implements Specification
{
    /**
     * @var int
     */
    private $sliceSize;

    /**
     * @var int
     */
    private $sliceNumber = 0;

    /**
     * @param int $sliceSize
     * @param int $sliceNumber
     */
    public function __construct($sliceSize, $sliceNumber = 0)
    {
        $this->sliceSize = $sliceSize;
        $this->sliceNumber = $sliceNumber;
    }

    /**
     * @return int
     */
    public function getSliceSize()
    {
        return $this->sliceSize;
    }

    /**
     * @return int
     */
    public function getSliceNumber()
    {
        return $this->sliceNumber;
    }
}
