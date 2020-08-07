test: artisan test

setup: env-prepare sqlite-prepare install key db-prepare

install:
	composer install

start:
	php artisan serve

db-prepare:
	php artisan migrate --seed

lint:
	composer phpcs

lint-fix:
	composer phpcbf

env-prepare:
	cp -n .env.example .env || true

sqlite-prepare:
	touch database/database.sqlite

key:
	php artisan key:generate

ide-helper:
	php artisan ide-helper:eloquent
	php artisan ide-helper:gen
	php artisan ide-helper:meta

.PHONY: test
