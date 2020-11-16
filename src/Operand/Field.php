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
use Happyr\DoctrineSpecification\Query\Selection\Selection;

class Field implements Operand, Selection
{
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var string|null
     */
    private $dqlAlias;

    /**
     * @param string      $fieldName
     * @param string|null $dqlAlias
     */
    public function __construct($fieldName, $dqlAlias = null)
    {
        $this->fieldName = $fieldName;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        return sprintf('%s.%s', $dqlAlias, $this->fieldName);
    }
}
