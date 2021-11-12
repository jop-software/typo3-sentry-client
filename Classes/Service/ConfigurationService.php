<?php

namespace Jops\TYPO3\Sentry\Service;

class ConfigurationService
{
	public static function getDsn(): string
	{
		return getenv("SENTRY_DSN") ?: "";
	}

	public static function getRelease(): string
	{
		return getenv("SENTRY_RELEASE") ?: "";
	}

	public static function getEnvironment(): string
	{
		return getenv("SENTRY_ENVIRONMENT") ?: "";
	}

	public static function getTracesSampleRate(): float
	{
		return floatval(getenv("SENTRY_TRACES_SAMPLE_RATE")) ?: 0.5;
	}
}
