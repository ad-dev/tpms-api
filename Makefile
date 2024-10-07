REPO_NAME=tpms-api

ifeq ($(HTTP_PORT),) # if HTTP_PORT is not set then use default port
HTTP_PORT := 8000
endif

all: build start env

build:
	docker build --build-arg REPO_NAME=${REPO_NAME} -t ${REPO_NAME} .
start:
	docker run --rm --name ${REPO_NAME} -p ${HTTP_PORT}:8000 -v ${PWD}/src:/${REPO_NAME}/src -v ${PWD}/config:/${REPO_NAME}/config -v ${PWD}/var:/${REPO_NAME}/var -d -t ${REPO_NAME}
env:
	docker cp .env ${REPO_NAME}:${REPO_NAME}\.env
stop:
	docker stop ${REPO_NAME}
shell:
	docker exec -ti ${REPO_NAME} bash
logs:
	docker logs --follow -t ${REPO_NAME}
