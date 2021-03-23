up: docker-up
init: docker-down-clear docker-pull docker-build docker-up bar-init
test: bar-test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-down-rmi:
	docker-compose down -v --remove-orphans --rmi all

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

bar-init: bar-composer-install bar-migrations bar-fixtures

bar-composer-install:
	docker-compose run --rm bar-php-cli composer install

bar-migrations:
	docker-compose run --rm bar-php-cli php bin/console doctrine:migrations:migrate --no-interaction

bar-fixtures:
	docker-compose run --rm bar-php-cli php bin/console doctrine:fixtures:load --no-interaction

bar-test:
	docker-compose run --rm bar-php-cli php bin/phpunit