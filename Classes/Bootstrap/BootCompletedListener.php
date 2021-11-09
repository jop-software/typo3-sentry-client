<?php

namespace Jops\TYPO3\Sentry\Bootstrap;

use Jops\TYPO3\Sentry\Service\SentryService;
use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;

class BootCompletedListener
{
	public function __invoke(BootCompletedEvent $event): void
	{
		SentryService::initialize();
		SentryService::startTransaction(sprintf("%s %s",
			$_SERVER["REQUEST_METHOD"],
			$_SERVER["SCRIPT_URI"],
		));
	}
}
