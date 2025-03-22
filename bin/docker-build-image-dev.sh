#!/usr/bin/env bash
set -a && source .env && set +a
DOCKER_BUILDKIT=1 docker build . -f ./docker/php/Dockerfile \
    --target $DOCKER_TARGET -t $DOCKER_TARGET --build-arg user=$DOCKER_USER --build-arg uid=$DOCKER_USER_UID
