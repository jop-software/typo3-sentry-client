<?php

namespace Jops\TYPO3\Sentry\Domain\Configuration;

use Exception;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

class Configuration
{

    protected ExtensionConfiguration $extensionConfiguration;

    public function __construct(
        ExtensionConfiguration $extensionConfiguration
    ) {
        $this->extensionConfiguration = $extensionConfiguration;

        try {
            $configuration = $this->extensionConfiguration->get("typo3_sentry_client");

            foreach ($configuration as $key => $value) {
                if (property_exists(__CLASS__, $key)) {
                    $this->$key = $value;
                }
            }
        } catch (Exception $exception) {
            return;
        }
    }

    protected bool $active = false;
    protected string $dsn = "";
    protected string $environment = "Production";
    protected string $release = "1.0.0";
    protected float $traces_sample_rate = 0.0;

    /**
     * @return ExtensionConfiguration
     */
    public function getExtensionConfiguration(): ExtensionConfiguration
    {
        return $this->extensionConfiguration;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @return string
     */
    public function getRelease(): string
    {
        return $this->release;
    }

    /**
     * @return float
     */
    public function getTracesSampleRate(): float
    {
        return $this->traces_sample_rate;
    }
}
