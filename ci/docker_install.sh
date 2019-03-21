#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
#apt-get install git phploc phpcpd phpmd php-pear -yqq
apt-get install git zip unzip -yqq
#apt-get install git php-phpunit-phploc php-phpunit-phpcpd php-phpmd-PHP-PMD -yqq

# Install phpunit, the tool that we will use for testing
#curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
#chmod +x /usr/local/bin/phpunit

curl --location --output /usr/local/bin/phpmd http://static.phpmd.org/php/latest/phpmd.phar
chmod +x /usr/local/bin/phpmd

curl --location --output /usr/local/bin/phploc https://phar.phpunit.de/phploc.phar
chmod +x /usr/local/bin/phploc

# Install mysql driver
# Here you can install any other extension that you need
docker-php-ext-install mysqli ext-gd

