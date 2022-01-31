<?php

namespace Unit\Domain\Configuration;

use Jops\TYPO3\Sentry\Domain\Configuration\Configuration;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class ConfigurationTest extends FunctionalTestCase
{
    public function testDefaultConfiguration()
    {
        $configuration = $this->getContainer()->get(Configuration::class);
        $this->assertNotNull($configuration);

        $this->assertFalse($configuration->isActive());
        $this->assertEquals("", $configuration->getDsn());
        $this->assertEquals("Production", $configuration->getEnvironment());
        $this->assertEquals("1.0.0", $configuration->getRelease());
        $this->assertEquals(0.0, $configuration->getTracesSampleRate());
    }

    public function testConfigurationFromEnvironment()
    {
        $configuration = [
            ["SENTRY_ACTIVE", true],
            ["SENTRY_DSN", "https://sentry.domain.org"],
            ["SENTRY_ENVIRONMENT", "Testing"],
            ["SENTRY_RELEASE", "0.0.0"],
            ["SENTRY_TRACES_SAMPLE_RATE", 0.5],
        ];

        // Set environment variables for testing.
        foreach ($configuration as $conf) {
            putenv("$conf[0]=\"$conf[1]\"");
        }

        $configuration = $this->getContainer()->get(Configuration::class);
        $this->assertNotNull($configuration);

        $this->assertTrue($configuration->isActive());
        $this->assertEquals("https://sentry.domain.org", $configuration->getDsn());
        $this->assertEquals("Testing", $configuration->getEnvironment());
        $this->assertEquals("0.0.0", $configuration->getRelease());
        $this->assertEquals(0.5, $configuration->getTracesSampleRate());
    }
}
