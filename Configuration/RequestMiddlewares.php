<?php

return [
	"frontend" => [
		"sentry-transaction" => [
			"target" => \Jops\TYPO3\Sentry\Middleware\SentryTransactionMiddleware::class
		]
	],
	"backend" => [
		"sentry-transaction" => [
			"target" => \Jops\TYPO3\Sentry\Middleware\SentryTransactionMiddleware::class
		]
	],
];
