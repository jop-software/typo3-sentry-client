<?php

namespace Jops\TYPO3\Sentry\Bootstrap;

use Jops\TYPO3\Sentry\Service\SentryService;
use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;
use TYPO3\CMS\Core\Http\ServerRequestFactory;

class BootCompletedListener
{
	public function __invoke(BootCompletedEvent $event): void
	{
		// We need to create our own request object because it seems to be that there is no way to get this
		// information from TYPO3 at this point of the boot process :-)
		$request = ServerRequestFactory::fromGlobals();

		SentryService::initialize();
		SentryService::startTransaction(sprintf("%s %s://%s%s%s",
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
