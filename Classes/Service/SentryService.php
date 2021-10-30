<?php

namespace Jops\TYPO3\Sentry\Service;

use Sentry\ClientBuilder;
use Sentry\SentrySdk;
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
			"environment" => ConfigurationService::getEnvironment()
		]);

		// We need to use the GeneralUtility to instantiate a LogManager, because we can't use either
		// DependencyInjection or the LoggerAwareTrait.
		$clientBuilder->setLogger(
			GeneralUtility::makeInstance(LogManager::class)
				->getLogger("Sentry-Client") // TODO: The name of the logger should be configurable
		);

		SentrySdk::init()->bindClient($clientBuilder->getClient());
	}

}
