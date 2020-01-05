#!/usr/bin/make
include .env
export

.PHONY: help
.DEFAULT_GOAL := help

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ Composer

install: ## Composer install dependencies
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer install -o

require: ## Run the composer require. (e.g make require PACKAGE="vendor/package")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer require ${PACKAGE}

dump: ## Run the composer dump
	docker exec -it ${DOCKER_APP_SERVICE_NAME} composer dump-autoload

##@ Yii

migrate: ## Run all the yii migrations
	docker exec -it ${DOCKER_APP_SERVICE_NAME} ./yii migrate

migrate-create: ## Run all the ./yii migrate/create. (e.g make migrate-create NAME="migrateName")
	docker exec -it ${DOCKER_APP_SERVICE_NAME} ./yii migrate/create ${NAME}

migrate-down: ## Run all the yii migrate/down
	docker exec -it ${DOCKER_APP_SERVICE_NAME} ./yii migrate/down

cache-clear: ## Flush all yii cache
	docker exec -it ${DOCKER_APP_SERVICE_NAME} ./yii cache/flush-all

##@ Database

db-backup: ## Backup database
	docker exec ${DOCKER_DB_SERVICE_NAME} /usr/bin/mysqldump -u root -p${DB_PASSWORD} ${DB_DATABASE} > backup.sql

db-restore: ## Restore database
	cat backup.sql | docker exec -i ${DOCKER_DB_SERVICE_NAME} /usr/bin/mysql -u root -p${DB_PASSWORD} ${DB_DATABASE}