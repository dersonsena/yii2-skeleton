# see: https://gitlab.com/dracones/nestec/blob/master/makefile
composer-require:
	docker exec -it yii2-skeleton-app composer require ${PACKAGE}

composer-dump:
	docker exec -it yii2-skeleton-app composer dump-autoload

migrate:
	docker exec -it yii2-skeleton-app yii migrate

migrate-create:
	docker exec -it yii2-skeleton-app yii migrate/create ${NAME}

migrate-down:
	docker exec -it yii2-skeleton-app yii migrate/down

cache-clear:
	docker exec -it yii2-skeleton-app yii cache/flush-all