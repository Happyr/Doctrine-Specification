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
use Happyr\DoctrineSpecification\DQLContextResolver;
use Happyr\DoctrineSpecification\Query\Selection\Selection;
use Symfony\Component\PropertyAccess\PropertyAccess;

final class Field implements Operand, Selection
{
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var string|null
     */
    private $context;

    /**
     * @param string      $fieldName
     * @param string|null $context
     */
    public function __construct(string $fieldName, ?string $context = null)
    {
        $this->fieldName = $fieldName;
        $this->context = $context;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $context
     *
     * @return string
     */
    public function transform(QueryBuilder $qb, string $context): string
    {
        if (null !== $this->context) {
            $context = sprintf('%s.%s', $context, $this->context);
        }

        $dqlAlias = DQLContextResolver::resolveAlias($qb, $context);

        return sprintf('%s.%s', $dqlAlias, $this->fieldName);
    }

    /**
     * @param mixed[]|object $candidate
     * @param string|null    $context
     *
     * @return mixed
     */
    public function execute($candidate, ?string $context = null)
    {
        $propertyPath = $this->fieldName;

        if (null !== $this->context) {
            $propertyPath = sprintf('%s.%s', $this->context, $propertyPath);
        }

        if (null !== $context) {
            $propertyPath = sprintf('%s.%s', $context, $propertyPath);
        }

        // If the candidate is a array, then we assume that all nested elements are also arrays.
        // The candidate cannot combine arrays and objects since Property Accessor expects different syntax for
        // accessing array and object elements.
        if (is_array($candidate)) {
            $propertyPath = sprintf('[%s]', str_replace('.', '][', $propertyPath));
        }

        return PropertyAccess::createPropertyAccessor()->getValue($candidate, $propertyPath);
    }
}
