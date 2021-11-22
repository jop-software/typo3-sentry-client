<?php

namespace Unit;

use Jops\TYPO3\Sentry\Service\ConfigurationService;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ConfigurationServiceTest extends UnitTestCase
{
	public function testDsnFromEnvironmentVariable(): void
	{
		$expected = "https://custom-sentry.tld";
		putenv("SENTRY_DSN={$expected}");
		$actual = ConfigurationService::getDsn();

		$this->assertEquals($expected, $actual);
		putenv("SENTRY_DSN=");
	}

	public function testDsnFallback(): void
	{
		$expected = "";
		$actual = ConfigurationService::getDsn();

		$this->assertEquals($expected, $actual);
	}

	public function testDsnFromExtensionConfiguration()
	{
		$configuration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
		$configuration->set("typo3_sentry_client.dsn", $expected = "https://sentry-from-config.tld");
		$actual = ConfigurationService::getDsn();

		$this->assertEquals($expected, $actual);
	}

}
