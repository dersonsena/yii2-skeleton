#!make
include .env
export $(shell sed 's/=.*//' .env)

install:
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer install -o

require:
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer require ${PACKAGE}

dump:
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer dump-autoload

migrate:
	docker exec -it ${DOCKER_APP_SERVICE_NAME} yii migrate

migrate-create:
	docker exec -it ${DOCKER_APP_SERVICE_NAME} yii migrate/create ${NAME}

migrate-down:
	docker exec -it ${DOCKER_APP_SERVICE_NAME} yii migrate/down

cache-clear:
	docker exec -it ${DOCKER_APP_SERVICE_NAME} yii cache/flush-all

db-backup:
	docker exec ${DOCKER_DB_SERVICE_NAME} /usr/bin/mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > backup.sql

db-restore:
	cat backup.sql | docker exec -i ${DOCKER_DB_SERVICE_NAME} /usr/bin/mysql -u root -p${DB_PASSWORD} ${DB_DATABASE}