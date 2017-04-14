<?php

namespace Happyr\DoctrineSpecification\Query;

use Happyr\DoctrineSpecification\Logic\AndX;

class Slice extends AndX
{
    /**
     * @param int $slice_size
     * @param int $slice_number
     */
    public function __construct($slice_size, $slice_number = 1)
    {
        if ($slice_number > 1) {
            parent::__construct(new Limit($slice_size), new Offset(($slice_number - 1) * $slice_size));
        } else {
            parent::__construct(new Limit($slice_size));
        }
    }
}
