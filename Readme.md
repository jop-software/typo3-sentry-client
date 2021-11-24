# TYPO3 Sentry Client
This TYPO3 extension allows you to send exceptions that occur in a TYPO3 installation to Sentry.

## Installation
Install this TYPO3 Extension via composer.
```console
composer require jop-software/typo3-sentry-client
```
**Attention:**  
Installation for non-composer installations on TYPO3 is not supported currently, because we depend on some
composer packages. See [Issue #4](https://github.com/jop-software/typo3_sentry_client/issues/4) for more information.
## Configuration
Currently, the only option to configure the extension is by environment variables.  
You can set them in the `.htaccess` file:
```apacheconf
###> jop-software/typo3-sentry-client
SetEnv SENTRY_DSN http://publicKey@your-sentry.tld/projectId
SetEnv SENTRY_ENVIRONMENT Production
SetEnv SENTRY_TRACES_SAMPLE_RATE 1.0
SetEnv SENTRY_RELEASE 9.10.19
###< jop-software/typo3-sentry-client
```

You can also configure the extension from the TYPO3 backend. You can set the same settings as you can with environment variables.  
Keep in mind that environment variables get prioritized over extension configuration. 

Add the `productionExceptionHandler` / `debugExceptionHandler` to your `LocalConfiguration.php` or `AdditionalConfiguration.php`file.
```php
$GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler'] = 'Jops\TYPO3\Sentry\Handler\ProductionExceptionHandler';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = 'Jops\TYPO3\Sentry\Handler\DebugExceptionHandler';
```
### Multiple Environments
If you use the same `.htaccess` file for multiple environments like Production / Development, you can move the
```apacheconf
SetEnv SENTRY_ENVIRONMENT Production
```
into the `ApplicationContext` section of the TYPO3 htaccess. e.G.:
```apacheconf
# Rules to set ApplicationContext based on hostname
RewriteCond %{HTTP_HOST} ^dev\.example\.com$
RewriteRule .? - [E=TYPO3_CONTEXT:Development,E=SENTRY_ENVIRONMENT:Development]
RewriteCond %{HTTP_HOST} ^staging\.example\.com$
RewriteRule .? - [E=TYPO3_CONTEXT:Production/Staging,E=SENTRY_ENVIRONMENT:Production-Staging]
RewriteCond %{HTTP_HOST} ^www\.example\.com$
RewriteRule .? - [E=TYPO3_CONTEXT:Production,E=SENTRY_ENVIRONMENT:Production]
```
## Local Development
We use [DDEV](https://ddev.readthedocs.io/en/stable/) for local development.  
With the extension you get a complete TYPO3 DDEV setup. Type `ddev start` to start the container.

## Headless

If you use [EXT:headless](https://github.com/TYPO3-Initiatives/headless), you can use the official [@nuxtjs/sentry](https://www.npmjs.com/package/@nuxtjs/sentry) module for the frontend.  
There is great documentation available [here](https://sentry.nuxtjs.org/).

This extension itself can be used together with [EXT:headless](https://github.com/TYPO3-Initiatives/headless) without any known problems. 

## License
This project is licensed under the [MIT License](./LICENSE)
