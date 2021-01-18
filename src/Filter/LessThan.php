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

namespace Happyr\DoctrineSpecification\Filter;

use Happyr\DoctrineSpecification\Operand\Operand;

final class LessThan extends Comparison
{
    /**
     * @param Operand|string $field
     * @param Operand|mixed  $value
     * @param string|null    $context
     */
    public function __construct($field, $value, ?string $context = null)
    {
        parent::__construct(self::LT, $field, $value, $context);
    }

    /**
     * @param mixed $field
     * @param mixed $value
     *
     * @return bool
     */
    protected function compare($field, $value): bool
    {
        return $field < $value;
    }
}
