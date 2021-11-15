<?php

namespace Jops\TYPO3\Sentry\Service;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ConfigurationService
{
	/**
	 * Get the value from extension configuration by the path.
	 *
	 * @param string $path
	 * @return string
	 * @throws ExtensionConfigurationExtensionNotConfiguredException
	 * @throws ExtensionConfigurationPathDoesNotExistException
	 */
	private static function getExtensionConfiguration(string $path): string
	{
		return strval(GeneralUtility::makeInstance(ExtensionConfiguration::class)
			->get("typo3_sentry_client", $path));
	}

	public static function getDsn(): string
	{
		if ($dsn = getenv("SENTRY_DSN")) {
			return strval($dsn);
		}

		if ($dsn = self::getExtensionConfiguration("dsn")) {
			return $dsn;
		}

		// TODO: we should throw an exception here instead of just returning an empty string because its required
		//  by the sentry SDK
		return "";
	}

	public static function getRelease(): string
	{
		if ($dsn = getenv("SENTRY_RELEASE")) {
			return strval($dsn);
		}

		if ($dsn = self::getExtensionConfiguration("release")) {
			return $dsn;
		}

		return "";
	}

	public static function getEnvironment(): string
	{
		if ($dsn = getenv("SENTRY_ENVIRONMENT")) {
			return strval($dsn);
		}

		if ($dsn = self::getExtensionConfiguration("environment")) {
			return $dsn;
		}

		return "";
	}

	public static function getTracesSampleRate(): float
	{
		if ($dsn = getenv("SENTRY_TRACES_SAMPLE_RATE")) {
			return strval($dsn);
		}

		if ($dsn = self::getExtensionConfiguration("traces_sample_rate")) {
			return floatval($dsn);
		}

		return 0.5;
	}
}
