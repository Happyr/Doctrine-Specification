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

namespace tests\Happyr\DoctrineSpecification\Operand\PlatformFunction;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Operand\PlatformFunction\Trim;
use PhpSpec\ObjectBehavior;
use tests\Happyr\DoctrineSpecification\Player;

/**
 * @mixin Trim
 */
final class TrimSpec extends ObjectBehavior
{
    public function it_should_transform(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo');

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(a.foo)');
    }

    public function it_should_transform_leading(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', Trim::LEADING);

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(LEADING FROM a.foo)');
    }

    public function it_should_transform_trailing(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', Trim::TRAILING);

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(TRAILING FROM a.foo)');
    }

    public function it_should_transform_both(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', Trim::BOTH);

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(BOTH FROM a.foo)');
    }

    public function it_should_transform_with_characters(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', '', 's');

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(\'s\' FROM a.foo)');
    }

    public function it_should_transform_leading_with_characters(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', Trim::LEADING, 's');

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(LEADING \'s\' FROM a.foo)');
    }

    public function it_should_transform_trailing_with_characters(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', Trim::TRAILING, 's');

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(TRAILING \'s\' FROM a.foo)');
    }

    public function it_should_transform_both_with_characters(QueryBuilder $qb): void
    {
        $this->beConstructedWith('foo', Trim::BOTH, 's');

        $context = 'a';

        $this->transform($qb, $context)->shouldReturn('TRIM(BOTH \'s\' FROM a.foo)');
    }

    public function it_should_execute(): void
    {
        $this->beConstructedWith('pseudo');

        $player = new Player(' Moe ', 'M', 1230);

        $this->execute($player)->shouldReturn('Moe');
    }

    public function it_should_execute_leading(): void
    {
        $this->beConstructedWith('pseudo', Trim::LEADING);

        $player = new Player(' Moe ', 'M', 1230);

        $this->execute($player)->shouldReturn('Moe ');
    }

    public function it_should_execute_trailing(): void
    {
        $this->beConstructedWith('pseudo', Trim::TRAILING);

        $player = new Player(' Moe ', 'M', 1230);

        $this->execute($player)->shouldReturn(' Moe');
    }

    public function it_should_execute_both(): void
    {
        $this->beConstructedWith('pseudo', Trim::BOTH);

        $player = new Player(' Moe ', 'M', 1230);

        $this->execute($player)->shouldReturn('Moe');
    }

    public function it_should_execute_with_characters(): void
    {
        $this->beConstructedWith('pseudo', '', '$');

        $player = new Player('$Moe$', 'M', 1230);

        $this->execute($player)->shouldReturn('Moe');
    }

    public function it_should_execute_leading_with_characters(): void
    {
        $this->beConstructedWith('pseudo', Trim::LEADING, '$');

        $player = new Player('$Moe$', 'M', 1230);

        $this->execute($player)->shouldReturn('Moe$');
    }

    public function it_should_execute_trailing_with_characters(): void
    {
        $this->beConstructedWith('pseudo', Trim::TRAILING, '$');

        $player = new Player('$Moe$', 'M', 1230);

        $this->execute($player)->shouldReturn('$Moe');
    }

    public function it_should_execute_both_with_characters(): void
    {
        $this->beConstructedWith('pseudo', Trim::BOTH, '$');

        $player = new Player('$Moe$', 'M', 1230);

        $this->execute($player)->shouldReturn('Moe');
    }
}
