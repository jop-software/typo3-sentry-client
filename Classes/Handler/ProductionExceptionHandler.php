<?php

namespace Jops\TYPO3\Sentry\Handler;

use Throwable;
use function Sentry\captureException;
use function Sentry\init;

class ProductionExceptionHandler extends \TYPO3\CMS\Core\Error\ProductionExceptionHandler
{
	public function handleException(Throwable $exception)
	{
		init([
			"dsn" => "placeholder"
		]);

		captureException($exception);

		parent::handleException($exception);
	}
}
