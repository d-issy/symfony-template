.DEFAULT_GOAL: help
help:
	@echo Plase check readme

.PHONY: setup start start/background stop clean
setup: composer/setup docker/build
	docker-compose run --rm node npm install
	docker-compose run --rm app php composer.phar install

start:
	docker-compose up

start/background:
	docker-compose up

stop:
	docker-compose stop

down:
	docker-compose down

clean:
	docker-compose down -v
	rm -rf node_modules
	rm -rf vendor

.PHONY: composer/*
composer.phar:
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified';  } else { echo 'Installer corrupt'; unlink('composer-setup.php');  } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"

composer/setup: composer.phar

.PHONY: docker/*
docker/build:
	docker-compose build

.PHONY: devserver/*
devserver/restart:
	docker-compose kill node
	docker-compose up -d

.PHONY: app/*
app/shell:
	docker-compose exec app ash
app/log:
	docker-compose logs -f
