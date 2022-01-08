FROM motork/leadspark-php7:20190520

ARG MONGODB_VERSION=1.5.3

# Install mongo
RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
    	openssl-dev \
	; \
	pecl install mongodb-${MONGODB_VERSION}; \
	docker-php-ext-enable mongodb; \
	pecl clear-cache; \
	\
	runDeps="$( \
    scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
      | tr ',' '\n' \
      | sort -u \
      | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .api-add-phpexts-rundeps $runDeps; \
	\
  	apk del .build-deps

WORKDIR /srv/behat

# build for production
ARG APP_ENV=prod
# prevent the reinstallation of vendors at every changes in the source code
COPY composer.json composer.lock ./

COPY behat.yml .
COPY tests tests

RUN set -eux; \
	composer install --no-progress --no-suggest; \
	composer clear-cache

RUN set -eux; \
	mkdir -p var/cache var/log

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
