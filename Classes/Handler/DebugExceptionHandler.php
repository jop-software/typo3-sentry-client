<?php

namespace Jops\TYPO3\Sentry\Handler;

use Jops\TYPO3\Sentry\Domain\Configuration\Configuration;
use Jops\TYPO3\Sentry\Service\SentryService;
use Throwable;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function Sentry\captureException;

class DebugExceptionHandler extends \TYPO3\CMS\Core\Error\DebugExceptionHandler
{
    public function handleException(Throwable $exception): void
    {
        $configuration = GeneralUtility::makeInstance(Configuration::class);

        if (! $dsn = $configuration->getDsn()) {
            parent::handleException($exception);
            return;
        }

        captureException($exception);

        parent::handleException($exception);
        SentryService::finishCurrentTransaction();
    }
}
