<?php

namespace Jops\TYPO3\Sentry\Bootstrap;

use TYPO3\CMS\Core\Core\Event\BootCompletedEvent;

class BootCompletedListener
{
	public function __invoke(BootCompletedEvent $event): void
	{
		// Silence is golden ...
	}
}
