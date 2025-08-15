<?php

$finder = PhpCsFixer\Finder::create()
    ->in(['src', 'tests'])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
    ])
    ->setFinder($finder);
