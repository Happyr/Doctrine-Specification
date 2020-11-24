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
use Happyr\DoctrineSpecification\Operand\Field;

/**
 * Class IndexBy.
 */
class IndexBy implements QueryModifier
{
    /**
     * @var Field
     */
    private $field;

    /**
     * @var string|null
     */
    private $dqlAlias;

    /**
     * @param Field|string $field    Field name for indexing
     * @param string|null  $dqlAlias DQL alias of field
     */
    public function __construct($field, $dqlAlias = null)
    {
        if (!($field instanceof Field)) {
            $field = new Field($field);
        }
        $this->field = $field;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @throws QueryException
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->indexBy($dqlAlias, $this->field->transform($qb, $dqlAlias));
    }
}
