# Transport Park Management System API

## requirements

`docker` and `make` must be installed on host machine to build and run this api

## build, start and run tests

`make all`

api server starts on 8000 port, if this port is already used on your local machine you can set env var HTTP_PORT to use different port

eg.: `HTTP_PORT=8080 make all`


run `make stop` to stop docker container

## API endpoints

/drivers - list all drivers

/trucks - list all trucks

/fleets - list all fleets

/orders - list all fleets that are in service

## `make` targets

`shell` enters the container (runs bash)

`build` - builds the container

`stop` - stops the container

`start` - starts the container

`init_db` - creates db and runs migrations

`logs` - watches server logs

`publish` - copy files from docker container to host (vendor/, composer.*, symphony.lock, phpunit.xml)

`all` - runs `build` `start` `init_db` `test` targets
