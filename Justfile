set shell := ["bash", "-eu", "-o", "pipefail", "-c"]
set dotenv-load := true

[private]
default: help

[group('General')]
[doc('Show the grouped command reference.')]
help:
    @just --list --list-heading $'\nStarter App commands:\n' --list-prefix '  '

[group('Setup')]
[doc('Install dependencies, start infrastructure, generate a key, and migrate the database.')]
setup:
    cp -n .env.docker .env || true
    docker compose up -d postgres redis
    docker compose run --rm app composer install
    docker compose run --rm node npm install
    docker compose run --rm app php artisan key:generate
    docker compose run --rm app php artisan migrate --seed

[group('Setup')]
[doc('Install PHP and JavaScript dependencies in Docker.')]
install:
    docker compose run --rm app composer install
    docker compose run --rm node npm install

[group('Environment')]
[doc('Start all application services in the background.')]
up:
    docker compose up -d

[group('Environment')]
[doc('Stop and remove application containers.')]
down:
    docker compose down

[group('Environment')]
[doc('Restart all running application services.')]
restart:
    docker compose restart

[group('Environment')]
[doc('Follow logs from all application services.')]
logs:
    docker compose logs -f

[group('Environment')]
[doc('Open a Bash shell in the PHP application container.')]
shell:
    docker compose exec app bash

[group('Environment')]
[doc('Clear Laravel caches in the PHP application container.')]
clear:
    docker compose exec app php artisan optimize:clear

[group('Database')]
[doc('Run pending migrations; accepts additional Artisan arguments.')]
migrate *args:
    docker compose exec app php artisan migrate {{args}}

[group('Database')]
[doc('Run database seeders; accepts additional Artisan arguments.')]
seed *args:
    docker compose exec app php artisan db:seed {{args}}

[group('Database')]
[doc('Rebuild and seed the database from scratch.')]
reset-db:
    docker compose exec app php artisan migrate:fresh --seed

[group('Quality')]
[doc('Run the PHP test suite; accepts additional Pest arguments.')]
test *args:
    docker compose exec -e APP_ENV=testing app vendor/bin/pest {{args}}

[group('Quality')]
[doc('Run the frontend Vitest suite.')]
test-js:
    docker compose exec node npm test

[group('Quality')]
[doc('Format PHP, JavaScript, TypeScript, and Vue files.')]
format:
    docker compose exec app vendor/bin/pint
    docker compose exec node npm run check:fix

[group('Quality')]
[doc('Check PHP formatting and static analysis plus frontend formatting, linting, and types.')]
lint:
    docker compose run --rm --no-deps app vendor/bin/pint --test
    docker compose run --rm --no-deps app composer types:check
    docker compose run --rm --no-deps node npm run check
    docker compose run --rm --no-deps node npm run types:check

[group('Quality')]
[doc('Check Gherkin scenarios, Pest descriptions, and documented steps with Gherkish.')]
gherkish *args:
    php artisan gherkish:check {{args}}

[group('Quality')]
[doc('Check Gherkin scenarios, Pest descriptions, and documented steps with Gherkish.')]
check: gherkish

[group('Quality')]
[doc('Run isolated linting, Gherkish, build, and Docker configuration checks.')]
check-all: lint gherkish build build-storybook
    docker compose config --quiet

[group('Build')]
[doc('Regenerate PHP-to-TypeScript contracts.')]
types:
    docker compose exec app php artisan typescript:transform

[group('Build')]
[doc('Build production frontend assets.')]
build:
    docker compose run --rm --no-deps node npm run build

[group('Build')]
[doc('Start Storybook and expose it to the host.')]
storybook:
    docker compose exec node npm run storybook -- --host 0.0.0.0

[group('Build')]
[doc('Build the static Storybook site.')]
build-storybook:
    docker compose run --rm --no-deps node npm run build-storybook

[group('Workers')]
[doc('Run the Laravel queue worker interactively.')]
queue:
    docker compose exec app php artisan queue:work --verbose --tries=3 --timeout=90
