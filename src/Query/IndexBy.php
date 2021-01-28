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

use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\DQLContextResolver;
use Happyr\DoctrineSpecification\Operand\Field;

/**
 * Class IndexBy.
 */
final class IndexBy implements QueryModifier
{
    /**
     * @var Field
     */
    private $field;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @param Field|string $field   Field name for indexing
     * @param string|null  $context DQL alias of field
     */
    public function __construct($field, ?string $context = null)
    {
        if (!($field instanceof Field)) {
            $field = new Field($field);
        }

        $this->field = $field;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @throws QueryException
     */
    public function modify(QueryBuilder $qb, string $context): void
    {
        if (null !== $this->context) {
            $context = sprintf('%s.%s', $context, $this->context);
        }

        $dqlAlias = DQLContextResolver::resolveAlias($qb, $context);

        $qb->indexBy($dqlAlias, $this->field->transform($qb, $context));
    }
}
