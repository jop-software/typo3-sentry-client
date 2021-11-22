<?php

namespace Jops\TYPO3\Sentry\Service;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ConfigurationService
{

	/**
	 * @param string $path
	 * @return mixed
	 * @throws ExtensionConfigurationExtensionNotConfiguredException
	 * @throws ExtensionConfigurationPathDoesNotExistException
	 */
	protected static function getExtensionConfiguration(string $path)
	{
		/** @var ExtensionConfiguration $extensionConfiguration */
		$extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
		return $extensionConfiguration->get('typo3_sentry_client', $path);
	}

	public static function getDsn(): string
	{
		return getenv("SENTRY_DSN")
			?: self::getExtensionConfiguration("dsn");
	}

	public static function getRelease(): string
	{
		return getenv("SENTRY_RELEASE")
			?: self::getExtensionConfiguration("release")
			?: "1.0.0";
	}

	public static function getEnvironment(): string
	{
		// TODO: Update the environment so its for sure compatible with sentry.
		return getenv("SENTRY_ENVIRONMENT")
			?: self::getExtensionConfiguration("environment")
			?: "Production";
	}

	public static function getTracesSampleRate(): float
	{
		return floatval(getenv("SENTRY_TRACES_SAMPLE_RATE"))
			?: floatval(self::getExtensionConfiguration("traces_sample_rate"))
			?: 0.5;
	}
}
