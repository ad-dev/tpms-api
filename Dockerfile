FROM php:8.3.3-alpine
ARG REPO_NAME
RUN curl -Ss getcomposer.org/installer -o cs && php ./cs --install-dir=bin --filename=composer
RUN composer require symfony/requirements-checker && composer remove symfony/requirements-checker
RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli
RUN composer create-project symfony/skeleton ${REPO_NAME}
WORKDIR  /${REPO_NAME}
RUN composer require symfony/uid
RUN composer require symfony/orm-pack
RUN composer require --dev symfony/maker-bundle
RUN composer require orm-fixtures --dev
RUN composer require doctrine/doctrine-fixtures-bundle --dev
RUN composer install
COPY ./src/ /${REPO_NAME}/src
WORKDIR  /${REPO_NAME}
CMD ["symfony", "server:start", "--port=8000"]
