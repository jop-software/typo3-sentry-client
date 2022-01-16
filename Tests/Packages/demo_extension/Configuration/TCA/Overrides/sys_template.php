<?php

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    "demo_extension",
    "Configuration/TypoScript/",
    "demo_extension"
);
