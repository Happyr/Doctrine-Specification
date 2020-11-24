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

namespace tests\Happyr\DoctrineSpecification\Filter;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Filter\Filter;
use Happyr\DoctrineSpecification\Filter\InstanceOfX;
use PhpSpec\ObjectBehavior;

/**
 * @mixin InstanceOfX
 */
class InstanceOfXSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('My\Model', 'o');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(InstanceOfX::class);
    }

    public function it_is_an_expression()
    {
        $this->shouldBeAnInstanceOf(Filter::class);
    }

    public function it_returns_expression_func_object(QueryBuilder $qb)
    {
        $this->getFilter($qb, null)->shouldReturn('o INSTANCE OF My\Model');
    }
}
