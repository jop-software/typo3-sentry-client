<?php

namespace Jops\TYPO3\Sentry\Handler;

use Jops\TYPO3\Sentry\Service\ConfigurationService;
use Throwable;

use function Sentry\init;
use function Sentry\captureException;

class DebugExceptionHandler extends \TYPO3\CMS\Core\Error\DebugExceptionHandler
{

	public function handleException(Throwable $exception)
	{
		if (! $dsn = ConfigurationService::getDsn()) {
			parent::handleException($exception);
			return;
		}

		init([
			"dsn" => $dsn,
			"release" => ConfigurationService::getRelease(),
			"environment" => ConfigurationService::getEnvironment()
		]);

		captureException($exception);

		parent::handleException($exception);
	}
}
