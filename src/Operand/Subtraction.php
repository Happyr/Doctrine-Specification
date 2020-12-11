<?php
declare(strict_types=1);

/**
 * This file is part of the Happyr Doctrine Specification package.
 *
 * (c) Tobias Nyholm <tobias@happyr.com>
 *     Kacper Gunia <kacper@gunia.me>
 *     Peter Gribanov <info@peter-gribanov.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Happyr\DoctrineSpecification\Operand;

final class Subtraction extends Arithmetic
{
    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     */
    public function __construct($field, $value)
    {
        parent::__construct(self::SUB, $field, $value);
    }

    /**
     * @param mixed $field
     * @param mixed $value
     *
     * @return mixed
     */
    protected function doExecute($field, $value)
    {
        return $field - $value;
    }
}
