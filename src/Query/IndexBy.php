<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;

/**
 * Class IndexBy.
 */
class IndexBy implements QueryModifier
{
    /**
     * Field.
     *
     * @var Field
     */
    private $field;

    /**
     * DQL Alias.
     *
     * @var string
     */
    private $dqlAlias;

    /**
     * IndexBy constructor.
     *
     * @param Field|string $field    Field name for indexing
     * @param string       $dqlAlias DQL alias of field
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
     * {@inheritdoc}
     */
    public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        $qb->indexBy($dqlAlias, $this->field->transform($qb, $dqlAlias));
    }
}
