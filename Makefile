.PHONY: unit
unit:
	php vendor/bin/behat

.PHONY: integration
integration:
	php vendor/bin/phpunit --testsuite "Integration tests"

.PHONY: api
api:
	php vendor/bin/phpunit --testsuite "API tests"

.PHONY: up
up:
	cd public && php -S localhost:8000

.SILENT::
