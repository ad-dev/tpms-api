# Transport Park Management System API

## requirements

`docker` and `make` must be installed on host machine to build and run this api

```
git clone https://github.com/ad-dev/tpms-api.git
cd tpms-api
make
```
(or `HTTP_PORT=8888 make` if different port `8000` is already used on host machine)

see details below:

## build, start and run tests



api server starts on 8000 port by default, if this port is already used on your local machine you can set env var `HTTP_PORT` to use different port

eg.: `HTTP_PORT=8080 make all`


run `make stop` to stop docker container

## API endpoints

/drivers - list all drivers

/trucks - list all trucks

/fleets - list all fleets

/orders - list all fleets that are in service

## `make` targets

`all` - executes `build` `start` `init_db` and `test` targets

`shell` enters the container (runs bash)

`build` - builds the container

`stop` - stops the container

`start` - starts the container

`init_db` - creates db and runs migrations

`logs` - watches server logs

`publish` - copy files from docker container to host (vendor/, composer.*, symphony.lock, phpunit.xml)

`all` - runs `build` `start` `init_db` `test` targets
