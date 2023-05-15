SHELL := /bin/sh

build: build-app build-database

build-app:
	@echo "Running composer install to manage dependencies..."

	composer install
build-database:
	@echo "Creating database for dev environment..."

	php bin/console doctrine:database:drop --force --env=dev || true
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:create --env=dev

	@echo "Database created. Loading demo data..."

	php bin/console hautelook:fixtures:load --no-bundles --env=dev -n

	@echo "Demo data loaded"
