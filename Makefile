up: docker-up
init: docker-down-clear docker-pull docker-build docker-up
test: bar-test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

bar-init: bar-composer-install

bar-composer-install:
	docker-compose run --rm bar-php-cli composer install

bar-test:
	docker-compose run --rm bar-php-cli php bin/phpunit