<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\ResultManagement;

use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Specification;

class OrderBy implements Specification
{
    const ASC = 'ASC';
    const DESC = 'DESC';

    /**
     * @var string
     */
    private $field;

    /**
     * @var array
     */
    private static $orders = [
        self::ASC,
        self::DESC,
    ];

    /**
     * @var string
     */
    private $order;

    /**
     * @param string $field
     * @param string $order
     */
    public function __construct($field, $order = self::ASC)
    {
        if (!in_array($order, self::$orders)) {
            throw InvalidArgumentException::invalidOrderType(self::$orders, $order);
        }

        $this->field = $field;
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }
}
