<?php

namespace Jops\TYPO3\Sentry\Middleware;

use Jops\TYPO3\Sentry\Service\SentryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SentryTransactionMiddleware implements MiddlewareInterface
{

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		$response = $handler->handle($request);

		SentryService::finishCurrentTransaction();

		return $response;
	}
}
