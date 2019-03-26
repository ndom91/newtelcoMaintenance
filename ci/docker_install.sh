#!/bin/bash

# composer + npm deploy:
#  https://docs.gitlab.com/ee/ci/examples/deployment/composer-npm-deploy.html
# 
#  another install guide incl. pushing to prod:
#  https://digidworks.com/post/2
# 

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
#apt-get install git phploc phpcpd phpmd php-pear -yqq
apt-get install gnupg2 -yqq
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 23E7166788B63E1E
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
apt-get install git zip unzip libpng-dev libgmp-dev -yqq
#apt-get install git php-phpunit-phploc php-phpunit-phpcpd php-phpmd-PHP-PMD -yqq

# Install phpunit, the tool that we will use for testing
#curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar
#chmod +x /usr/local/bin/phpunit

# https://github.com/phpmd/phpmd
curl --location --output /usr/local/bin/phpmd http://static.phpmd.org/php/latest/phpmd.phar
chmod +x /usr/local/bin/phpmd

# https://github.com/sebastianbergmann/phploc
curl --location --output /usr/local/bin/phploc https://phar.phpunit.de/phploc.phar
chmod +x /usr/local/bin/phploc

# Rollbar Deploy Notify
ACCESS_TOKEN=e0dbc12159df4dd3a6087170e3a8ace0
ENVIRONMENT=production
LOCAL_USERNAME=`whoami`
REVISION=`git rev-parse --verify HEAD`
curl https://api.rollbar.com/api/1/deploy/ \
  -F access_token=$ACCESS_TOKEN \
  -F environment=$ENVIRONMENT \
  -F revision=$REVISION \
  -F local_username=$LOCAL_USERNAME

# Install mysql driver
# Here you can install any other extension that you need
docker-php-ext-install mysqli gd zip gmp

#sed -i 's,^memory_limit =.*$,memory_limit = -1,' /usr/local/etc/php/php.ini
