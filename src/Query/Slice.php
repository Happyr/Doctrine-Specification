<?php

namespace Happyr\DoctrineSpecification\Query;

use Happyr\DoctrineSpecification\Logic\AndX;

class Slice extends AndX
{
    /**
     * @param int $sliceSize
     * @param int $sliceNumber
     */
    public function __construct($sliceSize, $sliceNumber = 1)
    {
        if ($sliceNumber > 1) {
            parent::__construct(new Limit($sliceSize), new Offset(($sliceNumber - 1) * $sliceSize));
        } else {
            parent::__construct(new Limit($sliceSize));
        }
    }
}
