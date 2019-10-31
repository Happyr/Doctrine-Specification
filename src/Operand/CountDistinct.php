<?php

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

class CountDistinct implements Operand
{
    /**
     * @var Operand|string
     */
    private $field;

    /**
     * @param Operand|string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, $dqlAlias)
    {
        $field = ArgumentToOperandConverter::toField($this->field);
        $field = $field->transform($qb, $dqlAlias);

        return sprintf('COUNT(DISTINCT %s)', $field);
    }
}
