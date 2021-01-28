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

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Alias;
use Happyr\DoctrineSpecification\Operand\Field;

final class GroupBy implements QueryModifier
{
    /**
     * @var Field|Alias
     */
    private $field;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @param Field|Alias|string $field
     * @param string|null        $context
     */
    public function __construct($field, ?string $context = null)
    {
        if (!($field instanceof Field) && !($field instanceof Alias)) {
            $field = new Field($field);
        }

        $this->field = $field;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        if (null !== $this->context) {
            $context = sprintf('%s.%s', $context, $this->context);
        }

        $qb->addGroupBy($this->field->transform($qb, $context));
    }
}
