build-dev:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml build
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php bash -c "composer install"
start-dev:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml up -d
stop-dev:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml down
shell:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php bash
test: test-unit test-integration
test-unit:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php vendor/bin/pest tests/Unit
test-integration:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php vendor/bin/pest tests/Feature

quality:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php vendor/bin/phpstan --memory-limit=4G
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml run --rm php vendor/bin/infection

build:
	docker-compose -f docker-compose.yml build
start:
	docker-compose -f docker-compose.yml up -d
stop:
	docker-compose -f docker-compose.yml down
