<?php

namespace Jops\TYPO3\Sentry\Service;

use Sentry\ClientBuilder;
use Sentry\SentrySdk;
use Sentry\Tracing\TransactionContext;

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
			"traces_sample_rate" =>  1.0,
		]);

		SentrySdk::init()->bindClient($clientBuilder->getClient());
	}

	/**
	 * Start a transaction with the given name.
	 * TODO: this needs some work for customisation and there should be a better / more
	 *  generic way to start a transaction.
	 *
	 * @param string $name
	 */
	public static function startTransaction(string $name)
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
