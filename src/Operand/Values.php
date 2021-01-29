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

namespace Happyr\DoctrineSpecification\Operand;

use Doctrine\ORM\QueryBuilder;
use Happyr\DoctrineSpecification\ValueConverter;

final class Values implements Operand
{
    /**
     * @var mixed[]
     */
    private $values;

    /**
     * @var int|string|null
     */
    private $valueType;

    /**
     * @param mixed[]         $values
     * @param int|string|null $valueType PDO::PARAM_* or \Doctrine\DBAL\Types\Type::* constant
     */
    public function __construct(array $values, $valueType = null)
    {
        $this->values = $values;
        $this->valueType = $valueType;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        $values = $this->values;
        foreach ($values as $k => $v) {
            $values[$k] = ValueConverter::convertToDatabaseValue($v, $qb);
        }

        $paramName = sprintf('comparison_%d', $qb->getParameters()->count());
        $qb->setParameter($paramName, $values, $this->valueType);

        return sprintf(':%s', $paramName);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     *
     * @return mixed[]
     */
    public function execute($candidate, ?string $context = null): array
    {
        return $this->values;
    }
}
