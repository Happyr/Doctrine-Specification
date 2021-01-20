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

namespace Happyr\DoctrineSpecification;

use Happyr\DoctrineSpecification\Specification\BaseSpecification as BaseBaseSpecification;

@trigger_error('The '.__NAMESPACE__.'\BaseSpecification class is deprecated since version 1.1 and will be removed in 2.0, use \Happyr\DoctrineSpecification\Specification\BaseSpecification instead.', E_USER_DEPRECATED);

/**
 * Extend this abstract class if you want to build a new spec with your domain logic.
 *
 * @deprecated This class is deprecated since version 1.1 and will be removed in 2.0, use \Happyr\DoctrineSpecification\Specification\BaseSpecification instead.
 */
abstract class BaseSpecification extends BaseBaseSpecification
{
}
