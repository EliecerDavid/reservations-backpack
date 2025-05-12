#! /usr/bin/make
help:           ## show help
	@cat Makefile | grep "##." | sed '2d;s/##//;s/://'

up:             ## run containers
	docker compose up -d --remove-orphans && sleep 5
	docker compose run --rm app composer install
	$(MAKE) create-env
	docker compose run --rm app php artisan migrate

	@if [ ! -L "./src/public/storage" ]; then \
		docker compose run --rm app php artisan storage:link; \
	fi

down:           ## stop and remove containers
	docker compose stop

build:          ## build containers
	docker compose build

admin:          ## create new admin user
	docker compose run --rm app php artisan app:create-admin

create-env:     ## create env file
	@if [ ! -f "./src/.env" ]; then\
		cp ./src/.env.example ./src/.env;\
		docker compose run --rm app php artisan key:generate;\
	fi

pint_analyze:   ## analyze errors of style of code with Laravel pint
	docker compose run --rm app ./vendor/bin/pint -v

pint_repair:    ## repair style of code with Laravel pint
	docker compose run --rm app ./vendor/bin/pint --repair
