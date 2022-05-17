<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Demo Extension',
    'description' => 'TYPO3 Demo Extension',
    'category' => 'misc',
    'author' => 'jop-software Inh. Johannes Przymusinski',
    'author_email' => 'info@jop-software.de',
    'author_company' => 'jop-software Inh. Johannes Przymusinski',
    'state' => 'in-dev',
    'clearCacheOnLoad' => true,
    'version' => '0.1.0',
    'constraints' => [
        'depends' => ['typo3' => '11.4.0-11.99.99'],
        'conflicts' => [],
        'suggests' => []
    ]
];
