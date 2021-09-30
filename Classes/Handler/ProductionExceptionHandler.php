<?php

namespace Jops\TYPO3\Sentry\Handler;

use Jops\TYPO3\Sentry\Service\ConfigurationService;
use Throwable;
use function Sentry\captureException;
use function Sentry\init;

class ProductionExceptionHandler extends \TYPO3\CMS\Core\Error\ProductionExceptionHandler
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
