REPO_NAME=tpms-api

ifeq ($(HTTP_PORT),) # if HTTP_PORT is not set then use default port
HTTP_PORT := 8000
endif

all: build start init_db test

build:
	docker build --build-arg REPO_NAME=${REPO_NAME} -t ${REPO_NAME} .
start:
	docker run --rm --name ${REPO_NAME} -p ${HTTP_PORT}:8000 -v ${PWD}/src:/${REPO_NAME}/src -v ${PWD}/config:/${REPO_NAME}/config -v ${PWD}/migrations:/${REPO_NAME}/migrations -v ${PWD}/var:/${REPO_NAME}/var -v ${PWD}/tests:/${REPO_NAME}/tests -d -t ${REPO_NAME}
stop:
	docker stop ${REPO_NAME}
shell:
	docker exec -ti ${REPO_NAME} bash
logs:
	docker logs --follow -t ${REPO_NAME}
publish:
	docker cp ${REPO_NAME}:/${REPO_NAME}/vendor ./
	docker cp ${REPO_NAME}:/${REPO_NAME}/composer.json ./composer.json
	docker cp ${REPO_NAME}:/${REPO_NAME}/composer.lock ./composer.lock
	docker cp ${REPO_NAME}:/${REPO_NAME}/symfony.lock ./symfony.lock
	docker cp ${REPO_NAME}:/${REPO_NAME}/phpunit.xml ./phpunit.xml

init_db:
	docker exec -it ${REPO_NAME} bin/console doctrine:database:create
	docker exec -it ${REPO_NAME} bin/console make:migration
	docker exec -it ${REPO_NAME} bin/console doctrine:migrations:migrate -n
	docker exec -it ${REPO_NAME} bin/console doctrine:fixtures:load -n
	docker exec -it ${REPO_NAME} bin/console doctrine:migrations:list

test:
	rm -f ./var/test_data.db
	docker cp ./phpunit.xml ${REPO_NAME}:/${REPO_NAME}/phpunit.xml
	docker exec -it ${REPO_NAME} bin/console --env=test doctrine:schema:create
	docker exec -it ${REPO_NAME} bin/console --env=test doctrine:fixtures:load -n
	docker exec -it ${REPO_NAME} bin/phpunit

reset_db:
	rm -f ./var/data.db
	rm -f ./migrations/Version*.php
