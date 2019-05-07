<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

/**
 * Class IndexBy.
 */
class IndexBy implements QueryModifier
{
    /**
     * Field name.
     *
     * @var string
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
     * @param string $field    Field name for indexing
     * @param string $dqlAlias DQL alias of field
     */
    public function __construct($field, $dqlAlias = null)
    {
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

        $qb->indexBy($dqlAlias, sprintf('%s.%s', $dqlAlias, $this->field));
    }
}
