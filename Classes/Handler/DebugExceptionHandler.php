<?php

namespace Jops\TYPO3\Sentry\Handler;

use Jops\TYPO3\Sentry\Service\ConfigurationService;
use Jops\TYPO3\Sentry\Service\SentryService;
use Throwable;

use function Sentry\captureException;

class DebugExceptionHandler extends \TYPO3\CMS\Core\Error\DebugExceptionHandler
{
    public function handleException(Throwable $exception): void
    {
        if (! $dsn = ConfigurationService::getDsn()) {
            parent::handleException($exception);
            return;
        }

        captureException($exception);

        parent::handleException($exception);
        SentryService::finishCurrentTransaction();
    }
}
