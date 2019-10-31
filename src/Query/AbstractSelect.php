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

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\Selection\ArgumentToSelectionConverter;
use Happyr\DoctrineSpecification\Query\Selection\Selection;

abstract class AbstractSelect implements QueryModifier
{
    /**
     * @var Selection[]
     */
    private $selections;

    /**
     * @param mixed $field
     */
    public function __construct($field)
    {
        // NEXT_MAJOR: use variable-length argument lists (...$fields)
        $this->selections = is_array($field) ? $field : func_get_args();
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $dqlAlias
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        $selections = [];
        foreach ($this->selections as $selection) {
            $selection = ArgumentToSelectionConverter::toSelection($selection);
            $selections[] = $selection->transform($qb, $dqlAlias);
        }

        $this->modifySelection($qb, $selections);
    }

    /**
     * @param QueryBuilder $qb
     * @param string[]     $selections
     */
    abstract protected function modifySelection(QueryBuilder $qb, array $selections);
}
