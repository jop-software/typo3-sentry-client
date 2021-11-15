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
		if ($release = getenv("SENTRY_RELEASE")) {
			return strval($release);
		}

		if ($release = self::getExtensionConfiguration("release")) {
			return $release;
		}

		return "";
	}

	public static function getEnvironment(): string
	{
		if ($environment = getenv("SENTRY_ENVIRONMENT")) {
			return strval($environment);
		}

		if ($environment = self::getExtensionConfiguration("environment")) {
			return $environment;
		}

		return "";
	}

	public static function getTracesSampleRate(): float
	{
		if ($traces_sample_rate = getenv("SENTRY_TRACES_SAMPLE_RATE")) {
			return floatval($traces_sample_rate);
		}

		if ($traces_sample_rate = self::getExtensionConfiguration("traces_sample_rate")) {
			return floatval($traces_sample_rate);
		}

		return 0.5;
	}
}
