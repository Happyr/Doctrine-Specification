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

namespace Happyr\DoctrineSpecification\Result;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;

/**
 * Class AsSingleScalar.
 */
class AsSingleScalar implements ResultModifier
{
    /**
     * @param AbstractQuery $query
     */
    public function modify(AbstractQuery $query)
    {
        $query->setHydrationMode(Query::HYDRATE_SINGLE_SCALAR);
    }
}
