<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true, // Aplica el estándar de estilo PSR-12 (incluye indentación y reglas)
        'array_syntax' => ['syntax' => 'short'], // Opcional: Prefiere la sintaxis corta ([])
    ])
    ->setFinder($finder);