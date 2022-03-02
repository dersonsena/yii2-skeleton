#!/bin/bash
include .env
SHELL := /bin/bash # Use bash syntax

export TZ=America/Sao_Paulo

export

.PHONY: help
.DEFAULT_GOAL := up

##@ Docker
up: ## Start all project containers
	@echo -e "\n~~> Starting up containers for ${PROJECT_NAME}..."
	@docker-compose up -d
	@echo -e "~> Access Application through url: http://localhost:${DOCKER_APP_PORT} or https://localhost:${DOCKER_APP_PORT_SSL}"

stop: ## Stop all project containers
	@echo -e "\n~~> Stoping all containers for ${PROJECT_NAME}..."
	@docker-compose stop
	@docker-compose rm -f
	@echo -e "done!\n"

restart: ## Stop, Remove and Start app containers
	@echo -e "\n~~> Restarting all containers for ${PROJECT_NAME}..."
	@make stop
	@make up

in: ## Enter in backend app container
	@docker exec -it "${PROJECT_NAME}-app" bash

in-db: ## Enter in app container
	@docker exec -it "${PROJECT_NAME}-db" bash

ps: ## List the project containers
	@docker-compose ps

logs: ## Show application logs as tail
	@docker-compose logs -f app

nginx-restart: ## Restart nginx service
	@docker exec -it "${PROJECT_NAME}-app" nginx -s reload

nginx-logs: ## Show application nginx logs as tail
	@docker exec -it "${PROJECT_NAME}-app" tail -f /var/log/nginx/application-error.log

##@ Composer

install: ## Composer install dependencies
	@echo -e "~~> Installing composer dependencies..."
	@docker exec -it "${PROJECT_NAME}-app" composer install -o
	@echo -e "done!\n"

require: ## Run the composer require. (e.g make require PACKAGE="vendor/package")
	@echo -e "~~> Installing ${PACKAGE} Composer package..."
	@docker exec -it "${PROJECT_NAME}-app" composer require -o "${PACKAGE}"
	@echo -e "done!\n"

require-dev: ## Run the composer require with dev dependency flag. (e.g make require-dev PACKAGE="vendor/package")
	@echo -e "~~> Installing ${PACKAGE} Composer Development package..."
	@docker exec -it "${PROJECT_NAME}-app" composer require --dev -o "${PACKAGE}"
	@echo -e "done!\n"

update: ## Run the composer update. (e.g make update)
	@echo -e "~~> Updating Composer packages..."
	@docker exec -it "${PROJECT_NAME}-app" composer update -o
	@echo -e "done!\n"

dump: ## Run the composer dump
	@docker exec -it "${PROJECT_NAME}-app" composer dump-autoload -o

##@ Quality Tools
cs: ## Run Code Sniffer Tool
	@echo -e "~~> Running PHP Code Sniffer Tool..."
	@docker exec -it "${PROJECT_NAME}-app" composer run phpcs
	@echo -e "done!\n"

fixer: ## Run PHP Code Beautifier Tool
	@echo -e "~~> Running PHP Code Beautifier Tool..."
	@docker exec -it "${PROJECT_NAME}-app" composer run phpcbf
	@echo -e "done!\n"

##@ Yii and Application

migrate: ## Run all the yii migrations
	@echo -e "\n~~> Running app migrations..."
	@docker exec -it "${PROJECT_NAME}-app" php ./yii migrate
	@echo -e "done!\n"

migrate-create: ## Run all the ./yii migrate/create. (e.g make migrate-create NAME="migrateName")
	@docker exec -it "${PROJECT_NAME}-app" php ./yii migrate/create "${NAME}"

migrate-down: ## Run all the yii migrate/down
	@docker exec -it "${PROJECT_NAME}-app" php ./yii migrate/down

migrate-fresh: ## Delete all tables from the database and apply all migrations from the beginning
	@docker exec -it "${PROJECT_NAME}-app" php ./yii migrate/fresh

model: ## Create a model using GII (e.g make model TABLE=users MODEL=User)
	@docker exec -it "${PROJECT_NAME}-app" php ./yii gii/model --tableName="${TABLE}" --modelClass="${MODEL}"

cache: ## Flush all yii cache
	@docker exec -it "${PROJECT_NAME}-app" php ./yii cache/flush-all

##@ PHP Unit - Tests

test: ## Run the all suite test
	@docker exec -it "${PROJECT_NAME}-app" composer run test

test-filter: ## Run a single test by method name (e.g make test-filter NAME="testYourTestName")
	@docker exec -it "${PROJECT_NAME}-app" composer run test:filter ${NAME}

test-unit: ## Run the application unit tests only
	@docker exec -it "${PROJECT_NAME}-app" composer run test:unit

test-integration: ## Run the application integration tests only
	@docker exec -it "${PROJECT_NAME}-app" composer run test:integration

test-coverage: ## Run the all suite test and generate the Code Coverage
	@docker exec -it -e XDEBUG_MODE=coverage "${PROJECT_NAME}-app" composer run test:coverage

test-coverage-ci: ## Run the all suite test and generate the Code Coverage
	@docker exec -i -e XDEBUG_MODE=coverage "${PROJECT_NAME}-app" composer run test:coverage-ci

##@ Database

db-backup: ## Backup database
	@docker exec "${PROJECT_NAME}-db" /usr/bin/mysqldump -u "${DB_USERNAME}" -p"${DB_PASSWORD}" "${DB_DATABASE}" > dump/database-dump.sql

db-restore: ## Restore database
	@cat dump/backup.sql | docker exec -i "${PROJECT_NAME}-db" /usr/bin/mysql -u "${DB_USERNAME}" -p"${DB_PASSWORD}" "${DB_DATABASE}"

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)
