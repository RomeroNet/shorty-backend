build-dev:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml build
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php bash -c "composer install"
start-dev:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml up -d
stop-dev:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml down
shell:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php bash
test:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php vendor/bin/pest

build:
	docker-compose -f docker-compose.yml build
start:
	docker-compose -f docker-compose.yml up -d
stop:
	docker-compose -f docker-compose.yml down
