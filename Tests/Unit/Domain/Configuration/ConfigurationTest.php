<?php

namespace Jops\TYPO3\Sentry\Tests\Unit\Domain\Configuration;

use TYPO3\TestingFramework\Core\BaseTestCase;
use Jops\TYPO3\Sentry\Domain\Configuration\Configuration;

class ConfigurationTest extends BaseTestCase
{
    public function testDefaultConfiguration()
    {
        $configuration = $this->getAccessibleMock(Configuration::class, ['dummy'], [], '', false);

        $this->assertFalse($configuration->isActive());
        $this->assertEquals("", $configuration->getDsn());
        $this->assertEquals("Production", $configuration->getEnvironment());
        $this->assertEquals("1.0.0", $configuration->getRelease());
        $this->assertEquals(0.0, $configuration->getTracesSampleRate());
        $this->assertEquals("", $configuration->getBlacklistPattern());
        $this->assertEquals(E_ALL, $configuration->getErrorLevel());
    }
}
