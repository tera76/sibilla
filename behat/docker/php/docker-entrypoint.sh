#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ "$1" = 'php-fpm' ] || [ "$1" = 'php' ] || [ "$1" = 'bin/console' ]; then
	PHP_INI_RECOMMENDED="$PHP_INI_DIR/php.ini-production"
	if [ "$APP_ENV" != 'prod' ]; then
		PHP_INI_RECOMMENDED="$PHP_INI_DIR/php.ini-development"
	fi
	ln -sf "$PHP_INI_RECOMMENDED" "$PHP_INI_DIR/php.ini"

	mkdir -p var/cache var/log
	# These are incompatible with AUFS.
	# See https://symfony.com/doc/current/setup/file_permissions.html for ref of chmod 777
	# setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
	# setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var

	chmod -R 777 var/log

	if [ "$APP_ENV" != 'prod' ]; then
		composer install --prefer-dist --no-progress --no-suggest --no-interaction
	fi
fi

exec docker-php-entrypoint "$@"
