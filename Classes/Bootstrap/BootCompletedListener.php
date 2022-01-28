<?php

namespace Jops\TYPO3\Sentry\Bootstrap;

use Jops\TYPO3\Sentry\Domain\Configuration\Configuration;
use Jops\TYPO3\Sentry\Service\ConfigurationService;
use Jops\TYPO3\Sentry\Service\SentryService;
use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;
use TYPO3\CMS\Core\Http\ServerRequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BootCompletedListener
{
    public function __invoke(BootCompletedEvent $event): void
    {
        $configuration = GeneralUtility::makeInstance(Configuration::class);

        if (! $configuration->isActive()) {
            return;
        }

        SentryService::initialize();

        // TODO: transaction support for CLI SAPI
        if (PHP_SAPI !== "cli") {
            $this->startTransactionForWeb();
        }
    }

    /**
     * Start a Sentry transaction for the web SAPI.
     * Creates the transaction from data store in the request object.
     *
     * @return void
     */
    private function startTransactionForWeb()
    {
        // We need to create our own request object because it seems to be that there is no way to get this
        // information from TYPO3 at this point of the boot process :-)
        $request = ServerRequestFactory::fromGlobals();

        SentryService::startTransaction(sprintf(
            "%s %s://%s%s%s",
            $request->getMethod(),
            $request->getUri()->getScheme(),
            $request->getUri()->getHost(),
            $request->getUri()->getPath(),
            $request->getUri()->getQuery()
                ? "?{$request->getUri()->getQuery()}"
                : "",
        ));
    }
}
