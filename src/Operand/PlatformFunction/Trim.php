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

namespace Happyr\DoctrineSpecification\Operand\PlatformFunction;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\Exception\InvalidArgumentException;
use Happyr\DoctrineSpecification\Operand\ArgumentToOperandConverter;
use Happyr\DoctrineSpecification\Operand\Operand;

/**
 * Trim the string by the given trim char, defaults to whitespaces.
 */
final class Trim implements Operand
{
    public const LEADING = 'LEADING';
    public const TRAILING = 'TRAILING';
    public const BOTH = 'BOTH';

    private const MODES = [
        self::LEADING,
        self::TRAILING,
        self::BOTH,
    ];

    /**
     * @var string|Operand
     */
    private $string;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string
     */
    private $characters;

    /**
     * @param Operand|string $string
     * @param string         $mode
     * @param string         $characters
     */
    public function __construct($string, string $mode = '', string $characters = '')
    {
        if ('' !== $mode && !in_array(strtoupper($mode), self::MODES, true)) {
            throw new InvalidArgumentException(sprintf(
                'The TRIM() function support "%s" mode, got "%s" instead.',
                implode('", "', self::MODES),
                $mode
            ));
        }

        $this->string = $string;
        $this->mode = $mode;
        $this->characters = $characters;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        $string = ArgumentToOperandConverter::toField($this->string)->transform($qb, $context);

        $expression = '';

        switch ($this->mode) {
            case self::LEADING:
                $expression = 'LEADING ';

                break;

            case self::TRAILING:
                $expression = 'TRAILING ';

                break;

            case self::BOTH:
                $expression = 'BOTH ';

                break;
        }

        if ('' !== $this->characters) {
            $expression .= sprintf('\'%s\' ', $this->characters);
        }

        if ('' !== $expression) {
            $expression .= 'FROM ';
        }

        return sprintf('TRIM(%s%s)', $expression, $string);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     *
     * @return string
     */
    public function execute($candidate, ?string $context = null): string
    {
        $string = ArgumentToOperandConverter::toField($this->string)->execute($candidate, $context);

        switch ($this->mode) {
            case self::LEADING:
                return $this->characters ? ltrim($string, $this->characters) : ltrim($string);

            case self::TRAILING:
                return $this->characters ? rtrim($string, $this->characters) : rtrim($string);

            default:
                return $this->characters ? trim($string, $this->characters) : trim($string);
        }
    }
}
