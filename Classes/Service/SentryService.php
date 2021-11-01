<?php

namespace Jops\TYPO3\Sentry\Service;

use Sentry\ClientBuilder;
use Sentry\SentrySdk;

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

}
