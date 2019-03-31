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

# install missing key
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 23E7166788B63E1E

# update apt and install required packages
echo -e "deb http://deb.debian.org/debian jessie main\ndeb http://security.debian.org jessie/updates main" > /etc/apt/sources.list

apt-get update -yqq
apt-get install gnupg2 git zip unzip libpng-dev libgmp-dev -yqq

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
