<?php

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Query\AbstractSelect;
use Happyr\DoctrineSpecification\Query\AddSelect;
use Happyr\DoctrineSpecification\Query\Selection\Selection;

class Field implements Operand, Selection
{
    /**
     * @var string
     */
    private $fieldName = '';

    /**
     * @var string
     */
    private $dqlAlias;

    /**
     * @var AbstractSelect
     */
    private $instance;

    /**
     * @param string              $fieldName
     * @param string|null         $dqlAlias
     * @param AbstractSelect|null $instance
     */
    public function __construct($fieldName, $dqlAlias = null, $instance = null)
    {
        $this->fieldName = $fieldName;
        $this->dqlAlias = $dqlAlias;
        $this->instance = $instance;
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
        if ($this->instance instanceof AddSelect) {
            return sprintf('%s', $this->fieldName);
        }

        return sprintf('%s.%s', $dqlAlias, $this->fieldName);
    }
}
