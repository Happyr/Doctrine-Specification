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

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\DQLContextResolver;
use Happyr\DoctrineSpecification\Exception\OperandNotExecuteException;

final class Alias implements Operand
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @param string $alias
     */
    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        return DQLContextResolver::resolveAlias($qb, $this->alias);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     */
    public function execute($candidate, ?string $context = null): void
    {
        throw new OperandNotExecuteException('The aliasing is not supported for execution.');
    }
}
