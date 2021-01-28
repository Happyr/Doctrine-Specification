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

namespace tests\Happyr\DoctrineSpecification;

final class Game
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var \DateTimeInterface|null
     */
    public $releaseAt;

    /**
     * @param string                  $name
     * @param \DateTimeInterface|null $releaseAt
     */
    public function __construct(string $name, ?\DateTimeInterface $releaseAt = null)
    {
        $this->name = $name;
        $this->releaseAt = $releaseAt;
    }
}
