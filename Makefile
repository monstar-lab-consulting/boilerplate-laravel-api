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
DB_PORT=3306
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
# get argument(database open port)
ENVIRONMENT=local
ifdef env
	ENVIRONMENT=$(env)
endif

#Docker Image Version
# php 8.0, nginx 1.19.7
#Docker Image Version
PHP_TAG=phpdockerio/php80-fpm:latest
HTTPD_TAG=nginx:1.19.7-alpine
DB_TAG=mysql:8.0.24

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
	docker build --rm -f dockers/DB.Dockerfile --platform=linux/x86_64 $(BUILD_DB_ARGS) -t $(DB_IMAGE_NAME) .
#Remove all images
rm-all-images:
	@echo ":::remove all images"
	-docker rmi $(DB_IMAGE_NAME) $(BASE_IMAGE_NAME):$(BASE_TAG)

#Up with rebuild
up-all:
	@echo ":::up all container"
	-docker-compose -f docker-compose-$(ENVIRONMENT).yml up  -d --build

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

KUBE_BASE_IMAGE=172.16.110.67:5000/boilerplate-base
KUBE_APP_IMAGE=172.16.110.67:5000/boilerplate-app
KUBE_DB_IMAGE=172.16.110.67:5000/boilerplate-db
KUBE_CLUSTER=--server=https://172.16.110.59:6443
APP_NAME=boilerplate

kubedbimage:
	@echo ":::build base image"
	docker build --rm -f dockers/DB.Dockerfile --platform=linux/x86_64 $(BUILD_DB_ARGS) -t $(KUBE_DB_IMAGE) .
	docker push $(KUBE_DB_IMAGE)

kubebaseimage:
	@echo ":::build base image"
	docker build --rm -f dockers/Base.Dockerfile $(BUILD_BASE_ARGS) -t $(KUBE_BASE_IMAGE):$(BASE_TAG) .
	docker push $(KUBE_BASE_IMAGE)

kubeappimage:
	@echo ":::build app image"
	docker build --rm -f dockers/Dockerfile --build-arg IMAGE_NAME=$(KUBE_BASE_IMAGE) --build-arg BASE_TAG=$(BASE_TAG) --build-arg PORT=$(PROXY_PORT) --build-arg ENV=$(ENVIRONMENT) -t $(KUBE_APP_IMAGE):$(BASE_TAG) .
	docker push $(KUBE_APP_IMAGE)
	@echo ":::remove untagged images"
	docker images -f "dangling=true" -q | xargs -r docker rmi

kubedeploy:
	@echo ":::create secret keys"
	sudo kubectl delete secret $(APP_NAME)-secrets --ignore-not-found
	sudo kubectl create secret generic $(APP_NAME)-secrets --from-env-file=environments/.env.kubernetes
	@echo ":::create storage if not exist"
	sudo kubectl apply -f kubernetes/storage.yaml
	@echo ":::build pod"
	sudo kubectl apply -f kubernetes/deployment.yaml

kubeservice:
	@echo ":::create service"
	sudo kubectl apply -f kubernetes/service.yaml

kubeimages: kubedbimage kubebaseimage kubeappimage

kubeinit: kubedbimage kubebaseimage kubeappimage kubedeploy kubeservice

kuberollout:
	@echo "::: rollout"
	sudo kubectl rollout restart deployment boilerplate-app-deployment

kubeup: kubeappimage kubedeploy kubeservice

kubeupdate: kubeappimage kuberollout

kubedown:
	@echo ":::delete deployment"
	sudo kubectl delete secret $(APP_NAME)-secrets --ignore-not-found
	sudo kubectl delete deploy $(APP_NAME)-app-deployment --ignore-not-found
	sudo kubectl delete service $(APP_NAME)-service --ignore-not-found
