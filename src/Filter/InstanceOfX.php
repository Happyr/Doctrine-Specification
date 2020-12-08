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

use Doctrine\ORM\QueryBuilder;

class InstanceOfX implements Filter
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string|null
     */
    private $dqlAlias;

    /**
     * @param string      $value
     * @param string|null $dqlAlias
     */
    public function __construct(string $value, ?string $dqlAlias = null)
    {
        $this->value = $value;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function getFilter(QueryBuilder $qb, string $dqlAlias): string
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        return (string) $qb->expr()->isInstanceOf($dqlAlias, $this->value);
    }
}
