# usage
 #   > make build env=local proxy_open_port=80
 # 2.make build example(PROXY don't need use.)
 #   > make build env=local
 #
 # * ssh private key path *
 # please read README
 #

# get argument(proxy open port)
PROXY_PORT=80
ifdef proxy_open_port
	PROXY_PORT=-p $(proxy_open_port):$(PROXY_PORT)
else
	PROXY_PORT_OPTION=
endif

# get argument(database open port)
DB_PORT=5432
ifdef database_open_port
	DB_PORT_OPTION=-p $(database_open_port):$(DB_PORT)
else
	DB_PORT_OPTION=
endif

# get user directory(arguments)
ifdef workspace
	USER_WORK_DIR=$(workspace)
else
	USER_WORK_DIR=$(shell pwd)
endif

#Base Tag.
# BASE_TAG=$(shell git rev-parse --short HEAD)
BASE_TAG=latest
COMMIT_SHA1=$(shell git rev-parse HEAD)

# test environment
ENVIRONMENT=$(env)

#Docker Image Version
# php 7.3, nginx 1.19.6
#Docker Image Version
PHP_TAG=phpdockerio/php73-fpm:latest
HTTPD_TAG=nginx:1.19.6-alpine
DB_TAG=bitnami/postgresql:11-debian-10

# Wokdir
WORK_DIR=/var/www/

# Image names for docker
BASE_IMAGE_NAME=boilerplate/proxy-php-base-$(ENVIRONMENT)
DB_IMAGE_NAME=boilerplate/db-$(ENVIRONMENT)

# Build args for Dockerfiles
BUILD_BASE_ARGS=--build-arg WORK_DIR=$(WORK_DIR) --build-arg ENVIRONMENT=$(ENVIRONMENT) --build-arg PHP_TAG=$(PHP_TAG)  --build-arg HTTPD_TAG=$(HTTPD_TAG)
BUILD_DB_ARGS=--build-arg IMAGE_NAME=$(DB_TAG) --build-arg PORT=$(DB_PORT)

# make images
all-images: base-image db-image

#Building base php image
base-image:
	@echo ":::Building Base Image"
	docker build --rm -f dockers/Base.Dockerfile $(BUILD_BASE_ARGS) -t $(BASE_IMAGE_NAME):$(BASE_TAG) .

db-image:
	echo ":::Building db image"
	docker build --rm -f dockers/DB.Dockerfile $(BUILD_DB_ARGS) -t $(DB_IMAGE_NAME) .
#Remove all images
rm-all-images:
	@echo ":::remove all images"
	-docker rmi $(DB_IMAGE_NAME) $(BASE_IMAGE_NAME):$(BASE_TAG)

#Up with rebuild
up-all:
	@echo ":::up all container"
	-docker-compose -f docker-compose-$(ENVIRONMENT).yml up  -d --force-recreate --build

#Up
up:
	@echo ":::up all container"
	-docker-compose -f docker-compose-$(ENVIRONMENT).yml up -d

#down
down:
	@echo ":::down all container"
	-docker-compose -f docker-compose-$(ENVIRONMENT).yml down

stop-all-cont:
	@echo ":::stop all container"
	-docker-compose -f docker-compose-$(ENVIRONMENT).yml stop

rm-all-cont:
	@echo ":::remove all container"
	-docker-compose -f docker-compose-$(ENVIRONMENT).yml rm
rm-all-vol:
	@echo ":::remove all volumn"
	-docker volume prune
rebuild-nocache:
	@echo ":::rebuild all image with no cache"
	-docker-compose -f docker-compose-$(ENVIRONMENT).yml build --no-cache
