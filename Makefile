ARGS = $(filter-out $@,$(MAKECMDGOALS))

.PHONY: setup
setup:
	php bin/console app:setup

.PHONY: unit
unit:
	php vendor/bin/phpunit --testsuite "Unit tests"

.PHONY: behat
behat:
	php vendor/bin/behat "${ARGS}"

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
