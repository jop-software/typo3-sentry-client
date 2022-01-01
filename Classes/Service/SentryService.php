<?php

namespace Jops\TYPO3\Sentry\Service;

use Sentry\ClientBuilder;
use Sentry\SentrySdk;
use Sentry\State\Scope;
use Sentry\Tracing\TransactionContext;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SentryService
{
    /**
     * Initialize the Sentry Client
     * This replaces the Sentry\init() function and adds some functionality to it.
     */
    public static function initialize(): void
    {
        $clientBuilder = ClientBuilder::create([
            "dsn" => ConfigurationService::getDsn(),
            "release" => ConfigurationService::getRelease(),
            "environment" => ConfigurationService::getEnvironment(),
            "traces_sample_rate" => ConfigurationService::getTracesSampleRate()
        ]);

        // We need to use the GeneralUtility to instantiate a LogManager, because we can't use either
        // DependencyInjection or the LoggerAwareTrait.
        $clientBuilder->setLogger(
            GeneralUtility::makeInstance(LogManager::class)
                ->getLogger("Sentry-Client")
            // TODO: The name of the logger should be configurable
        );

        SentrySdk::init()->bindClient($clientBuilder->getClient());

        SentrySdk::getCurrentHub()->configureScope(function (Scope $scope): void {
            $scope->setTag('typo3.version', (new Typo3Version())->getVersion());
            $scope->setTag('typo3.application-context', (string)Environment::getContext());
        });
    }

    /**
     * Start a transaction with the given name.
     * TODO: this needs some work for customisation and there should be a better / more
     *  generic way to start a transaction.
     *
     * @param string $name
     */
    public static function startTransaction(string $name): void
    {
        $hub = SentrySdk::getCurrentHub();
        $context = new TransactionContext();
        $context->setName($name);
        $context->setOp("typo3.request");
        $hub->setSpan($hub->startTransaction($context));
    }

    /**
     * Checks for a transaction in the current hub and calls finish() on it.
     * Returns a boolean, weather a transaction has been found.
     *
     * @return bool
     */
    public static function finishCurrentTransaction(): bool
    {
        $hub = SentrySdk::getCurrentHub();
        if (($transaction = $hub->getTransaction()) === null) {
            return false;
        }

        $transaction->finish();
        return true;
    }
}
