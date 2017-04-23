<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\ResultModifier;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Parameter;
use Happyr\DoctrineSpecification\ResultModifier\RoundDateTime;
use Happyr\DoctrineSpecification\ResultModifier\ResultModifier;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformer;

class RoundDateTimeTransformer implements QueryTransformer
{
    /**
     * @param ResultModifier $modifier
     * @param AbstractQuery  $query
     */
    public function transform(ResultModifier $modifier, AbstractQuery $query)
    {
        if ($modifier instanceof RoundDateTime) {
            foreach ($query->getParameters() as $parameter) {
                /* @var $parameter Parameter */
                if ($parameter->getValue() instanceof \DateTimeInterface) {
                    // round down so that the results do not include data that should not be there.
                    $date = clone $parameter->getValue();
                    $date = $date->setTimestamp(
                        floor($date->getTimestamp() / $modifier->getRoundSeconds()) *
                        $modifier->getRoundSeconds()
                    );

                    $query->setParameter($parameter->getName(), $date, $parameter->getType());
                }
            }
        }
    }
}
