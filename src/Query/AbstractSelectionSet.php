<?php

namespace Happyr\DoctrineSpecification\Query;

use Doctrine\ORM\QueryBuilder;

/**
 * Class AbstractSelectionSet.
 */
abstract class AbstractSelectionSet implements QueryModifier
{
    /**
     * Field names.
     *
     * @var string[]
     */
    private $fields;

    /**
     * DQL Alias.
     *
     * @var string
     */
    private $dqlAlias;

    /**
     * SelectionSet constructor.
     *
     * @param string[]|string $fields   List of fields or map entityField -> resultField
     * @param string|null     $dqlAlias DQL alias
     */
    public function __construct($fields, $dqlAlias = null)
    {
        $this->fields = (array) $fields;
        $this->dqlAlias = $dqlAlias;
    }

    /**
     * {@inheritdoc}
     */
    final public function modify(QueryBuilder $qb, $dqlAlias)
    {
        if (null !== $this->dqlAlias) {
            $dqlAlias = $this->dqlAlias;
        }

        $fields = $this->getSelection($dqlAlias);

        $this->modifySelection($fields, $qb);
    }

    /**
     * Modify selection set in given query builder.
     *
     * @param string[]     $fields Prepared set of fields
     * @param QueryBuilder $qb     Query builder object
     *
     * @return mixed
     */
    abstract protected function modifySelection(array $fields, QueryBuilder $qb);

    /**
     * Return fields selection.
     *
     * @param string $dqlAlias DQL alias
     *
     * @return array
     */
    private function getSelection($dqlAlias)
    {
        $result = [];
        foreach ($this->fields as $k => $v) {
            $isAliased = is_string($k) && is_string($v);
            $fieldName = $isAliased ? $k : $v;

            list($fieldAlias, $fieldName) = explode('.', $fieldName, 2) + [null, null];
            if (null === $fieldName) {
                $fieldName = $fieldAlias;
                $fieldAlias = $dqlAlias;
            }

            $result[] = $isAliased ? sprintf('%s.%s AS %s', $fieldAlias, $fieldName, $v) :
                sprintf('%s.%s', $fieldAlias, $fieldName);
        }

        return $result;
    }
}
