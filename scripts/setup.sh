#!/bin/bash

ENV_PATH="${PWD}/.env"

if [ ! -f "$ENV_PATH" ];
then
	echo "~~> Creating the .env file from .env.sample..."

	cp "${PWD}/.env.sample" "${ENV_PATH}"

	echo "~~> Filling some env variables..."

	PROJECT_NAME=$(grep PROJECT_NAME .env | cut -d '=' -f2)
	VALIDATION_KEY=$(openssl rand -hex 24)

	sed -i "" "s/YOUR_VALIDATION_KEY/${VALIDATION_KEY}/g" "$ENV_PATH"
	sed -i "" "s/host=your-db-host/host=${PROJECT_NAME}-db/g" "$ENV_PATH"

	echo "[OK]"
	echo ""
fi