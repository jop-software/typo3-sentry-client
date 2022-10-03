<?php

namespace Jops\TYPO3\Sentry\Service;

use Jops\TYPO3\Sentry\Domain\Configuration\Configuration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Blacklist
{
    /**
     * Check weather the given string gets matched by the configured blacklist regex.
     * If the blacklist regex is empty, this will always return false.
     */
    public static function isExcluded(string $className): bool
    {
        $configuration = GeneralUtility::makeInstance(Configuration::class);
        $pattern = $configuration->getBlacklistPattern();

        // When the pattern is empty (not set), nothing should be excluded, so we just return false.
        if ($pattern === "") {
            return false;
        }

        return preg_match($pattern, $className) > 0;
    }
}
