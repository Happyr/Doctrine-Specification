<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM;

use Doctrine\ORM\Query;
use Happyr\DoctrineSpecification\EntitySpecificationRepositoryInterface as BaseEntitySpecificationRepositoryInterface;
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;
use Happyr\DoctrineSpecification\Specification;

/**
 * This interface should be used by an EntityRepository implementing the Specification pattern.
 */
interface EntitySpecificationRepositoryInterface extends BaseEntitySpecificationRepositoryInterface
{
    /**
     * Prepare a Query with a Specification.
     *
     * @param Specification  $specification
     * @param ResultModifier $modifier
     *
     * @return Query
     */
    public function getQuery(Specification $specification, ResultModifier $modifier);

    /**
     * @param string $alias
     *
     * @return self
     */
    public function setAlias($alias);

    /**
     * @param DoctrineORMTransformer $transformer
     *
     * @return self
     */
    public function setTransformer(DoctrineORMTransformer $transformer);
}
