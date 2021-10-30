<?php

namespace Jops\TYPO3\Sentry\Bootstrap;

use Jops\TYPO3\Sentry\Service\SentryService;
use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;

class BootCompletedListener
{
	public function __invoke(BootCompletedEvent $event): void
	{
		SentryService::initialize();
	}
}
