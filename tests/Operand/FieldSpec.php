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

namespace tests\Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\Field;
use Happyr\DoctrineSpecification\Operand\Operand;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Field
 */
final class FieldSpec extends ObjectBehavior
{
    private $fieldName = 'foo';

    public function let(): void
    {
        $this->beConstructedWith($this->fieldName);
    }

    public function it_is_a_field(): void
    {
        $this->shouldBeAnInstanceOf(Field::class);
    }

    public function it_is_a_operand(): void
    {
        $this->shouldBeAnInstanceOf(Operand::class);
    }

    public function it_is_transformable(QueryBuilder $qb): void
    {
        $context = 'a';
        $expression = 'a.foo';

        $this->transform($qb, $context)->shouldReturn($expression);
    }

    public function it_is_change_dql_alias(QueryBuilder $qb): void
    {
        $context = 'a';
        $expression = 'b.foo';

        $this->beConstructedWith($this->fieldName, 'b');
        $this->transform($qb, $context)->shouldReturn($expression);
    }
}
