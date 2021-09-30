# TYPO3 Sentry Client
This TYPO3 extension allows you to send exceptions that occur in a TYPO3 installation to Sentry.

## Local Development
We use [DDEV](https://ddev.readthedocs.io/en/stable/) for local development.  
With the extension you get a complete TYPO3 DDEV setup. Type `ddev start` to start the container.

## Configuration
Currently, the only option to configure the extension is by environment variables.  
You can set them in the `.htaccess` file:
```apacheconf
###> jop-software/typo3-sentry-client
SetEnv SENTRY_DSN http://publicKey@your-sentry.tld/projectId
SetEnv SENTRY_ENVIRONMENT Production
SetEnv SENTRY_RELASE 9.10.19
###< jop-software/typo3-sentry-client
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

## License
This project is licensed under the [MIT License](./LICENSE)
