#!/bin/bash
include .env
SHELL := /bin/bash # Use bash syntax

export TZ=America/Sao_Paulo

export

.PHONY: help
.DEFAULT_GOAL := run

run:
	@make up
	@make install
	@make migrate

##@ Docker
up: ## Start all project containers
	@echo -e "\n~~> Starting up containers for ${PROJECT_NAME}..."
	docker-compose up -d
	@echo -e "~~> [OK]\n"

in: ## Enter in app container
	@docker exec -it "${PROJECT_NAME}-app" bash

ps: ## List the project containers
	@docker-compose ps

##@ Composer

install: ## Composer install dependencies
	@echo -e "~~> Installing composer dependencies..."
	@docker exec -it "${PROJECT_NAME}-app" composer install -o
	@echo -e "~~> [OK]\n"

require: ## Run the composer require. (e.g make require PACKAGE="vendor/package")
	@docker exec -it "${PROJECT_NAME}-app" composer require "${PACKAGE}"

dump: ## Run the composer dump
	@docker exec -it "${PROJECT_NAME}-app" composer dump-autoload -o

##@ Yii

migrate: ## Run all the yii migrations
	@echo -e "\n~~> Running app migrations..."
	@docker exec -it "${PROJECT_NAME}-app" ./yii migrate
	@echo -e "~~> [OK]\n"

migrate-create: ## Run all the ./yii migrate/create. (e.g make migrate-create NAME="migrateName")
	@docker exec -it "${PROJECT_NAME}-app" ./yii migrate/create "${NAME}"

migrate-down: ## Run all the yii migrate/down
	@docker exec -it "${PROJECT_NAME}-app" ./yii migrate/down

cache-clear: ## Flush all yii cache
	@docker exec -it "${PROJECT_NAME}-app" ./yii cache/flush-all

##@ Database

db-backup: ## Backup database
	@docker exec "${PROJECT_NAME}-db" /usr/bin/mysqldump -u root -p"${DB_PASSWORD}" "${DB_DATABASE}" > backup.sql

db-restore: ## Restore database
	@cat backup.sql | docker exec -i "${PROJECT_NAME}-db" /usr/bin/mysql -u root -p"${DB_PASSWORD}" "${DB_DATABASE}"

help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)