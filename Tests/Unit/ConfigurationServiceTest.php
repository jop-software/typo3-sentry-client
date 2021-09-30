<?php

namespace Unit;

use Jops\TYPO3\Sentry\Service\ConfigurationService;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ConfigurationServiceTest extends UnitTestCase
{
	public function testDSNIsEmptyWithoutEnvironmentVariable()
	{
		$this->assertEquals("", ConfigurationService::getDsn());
	}

	public function testEnvironmentIsEmptyWithoutEnvironmentVariable()
	{
		$this->assertEquals("", ConfigurationService::getEnvironment());
	}

	public function testReleaseIsEmptyWithoutEnvironmentVariable()
	{
		$this->assertEquals("", ConfigurationService::getRelease());
	}
}
