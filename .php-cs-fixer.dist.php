<?php
declare(strict_types=1);

$header = <<<EOF
This file is part of the Happyr Doctrine Specification package.

(c) Tobias Nyholm <tobias@happyr.com>
    Kacper Gunia <kacper@gunia.me>
    Peter Gribanov <info@peter-gribanov.ru>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$rules = [
    '@PSR2' => true,
    '@Symfony' => true,
    '@Symfony:risky' => true,
    '@PhpCsFixer' => true,
    '@PhpCsFixer:risky' => true,
    '@PHP70Migration' => true,
    '@PHP70Migration:risky' => true,
    'header_comment' => [
        'comment_type' => 'PHPDoc',
        'header' => $header,
    ],
    'array_syntax' => ['syntax' => 'short'],
    'no_superfluous_phpdoc_tags' => false,
    'single_line_throw' => false,
    'blank_line_after_opening_tag' => false,
    'ordered_imports' => [
        'sort_algorithm' => 'alpha',
    ],
    'phpdoc_align' => [
        'tags' => ['param', 'return', 'throws', 'type', 'var'],
    ],
    'phpdoc_types_order' => [
        'null_adjustment' => 'always_last',
        'sort_algorithm' => 'none',
    ],
    'native_constant_invocation' => false,
    'native_function_invocation' => false,
    'ordered_class_elements' => false,
    'operator_linebreak' => [
        'position' => 'end',
    ],
];

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
    ->notPath('bootstrap.php')
;

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
;
