<?php

namespace Jops\TYPO3\Sentry\Handler;

use Jops\TYPO3\Sentry\Domain\Configuration\Configuration;
use Jops\TYPO3\Sentry\Service\SentryService;
use Throwable;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function Sentry\captureException;

class ProductionExceptionHandler extends \TYPO3\CMS\Core\Error\ProductionExceptionHandler
{
    public function handleException(Throwable $exception): void
    {
        $configuration = GeneralUtility::makeInstance(Configuration::class);

        if (($dsn = $configuration->getDsn()) === '' || ($dsn = $configuration->getDsn()) === '0') {
            parent::handleException($exception);
            return;
        }

        captureException($exception);

        parent::handleException($exception);
        SentryService::finishCurrentTransaction();
    }
}
