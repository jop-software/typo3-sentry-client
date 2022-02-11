<?php

namespace Jops\TYPO3\Sentry\Domain\Configuration;

use Exception;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

class Configuration
{
    protected ExtensionConfiguration $extensionConfiguration;

    protected bool $active = false;
    protected string $dsn = "";
    protected string $environment = "Production";
    protected string $release = "1.0.0";
    protected float $traces_sample_rate = 0.0;

    /**
     * Configuration constructor.
     *
     * Builds the Configuration classes and respects priority for different configuration sources.
     * Configuration gets loaded from. (Lower overwrites higher)
     *   1. Environment Variables
     *   2. TYPO3 Extension configuration
     *
     * @param ExtensionConfiguration $extensionConfiguration
     */
    public function __construct(
        ExtensionConfiguration $extensionConfiguration
    ) {
        $this->extensionConfiguration = $extensionConfiguration;
        $this->populateWithEnvironmentVariables();

        try {
            /** @var array<string> $configuration */
            $configuration = $this->extensionConfiguration->get("typo3_sentry_client");

            foreach ($configuration as $key => $value) {
                if (property_exists(__CLASS__, $key) && $value !== "") {
                    $this->{$key} = $value;
                }
            }
        } catch (Exception $exception) {
            return;
        }
    }

    /**
     * Populate $this with configuration from environment variables.
     * If the environment variable is not set, the property does not get set and remains at the default value.
     *
     * @return void
     */
    private function populateWithEnvironmentVariables(): void
    {
        $envMapping = [
            ["active", "SENTRY_ACTIVE"],
            ["dsn", "SENTRY_DSN"],
            ["environment", "SENTRY_ENVIRONMENT"],
            ["release", "SENTRY_RELEASE"],
            ["traces_sample_rate", "SENTRY_TRACES_SAMPLE_RATE"],
        ];

        foreach ($envMapping as $conf) {
            $value = getenv($conf[1]);
            if ($value) {
                $type = gettype($this->{$conf[0]});
                settype($value, $type);
                // FIXME: Remove comment when phpstan has proper support for \settype();
                // @phpstan-ignore-next-line
                $this->{$conf[0]} = $value;
            }
        }
    }

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
