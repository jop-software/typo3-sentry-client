<?php

use Jops\TYPO3\Sentry\Middleware\SentryTransactionMiddleware;

return [
    "frontend" => [
        "sentry-transaction" => [
            "target" => SentryTransactionMiddleware::class
        ]
    ],
    "backend" => [
        "sentry-transaction" => [
            "target" => SentryTransactionMiddleware::class
        ]
    ],
];
