<?php

$EM_CONF[$_EXTKEY] = [
	'title' => 'Sentry Client for TYPO3',
	'description' => 'Use Sentry to track errors in your TYPO3-installation',
	'category' => 'misc',
	'author' => 'jop-software Inh. Johannes Przymusinski',
	'author_email' => 'info@jop-software.de',
	'author_company' => 'jop-software Inh. Johannes Przymusinski',
	'state' => 'stable',
	'clearCacheOnLoad' => true,
	'version' => '1.5.1',
	'constraints' => [
		'depends' => ['typo3' => '11.4.0-11.99.99'],
		'conflicts' => [],
		'suggests' => []
	]
];
