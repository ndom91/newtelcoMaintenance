#!/bin/bash

echo '##################################'
echo '#                                #'
echo '#      Newtelco Maintenance      #'
echo '#         Install Script         #'
echo '#              v0.1              #'
echo '#  '$(date)'  #'
echo '#                                #'
echo '##################################'
echo ''

PWD=$(pwd)

echo '[*] Creating dirs'
mkdir msg
mkdir logs
chown www-data: logs
chmod 775 logs

case "$1" in
	
	# production 
	prod)
	echo '[*] Copying production apache configs'
	sed -i "s|\[WORKING_DIR\]|$PWD/public|" configs/apache2/maintenancedb.production.conf
	cp configs/apache2/maintenancedb.production.conf /etc/apache2/sites-enabled/maintenancedb.conf
	;;

	# development 
	dev)
	echo '[*] Copying development apache configs'
	sed -i "s|\[WORKING_DIR\]|$PWD/public|" configs/apache2/maintenancedb.development.conf
	cp configs/apache2/maintenancedb.development.conf /etc/apache2/sites-enabled/maintenancedb-dev.conf
	;;
	
	# Any other input at $0
	*)
	echo '[*] Usage: sudo ./install.sh {prod|dev}'
	exit 1
esac

echo ''
echo '[*] Fixing permissions'
chown -R www-data:ndo *
chmod -R 775 *

echo ''
echo '[*] Reloading apache configs'
apachectl -k graceful

echo '[*] checking node/composer dependency managers'

if [ -f "/usr/bin/node" ]; then
  echo '[*] node exists'
else 
  echo '[*] installing node'
  curl -s https://install-node.now.sh | bash -s --
fi

if [ -f '/usr/local/bin/composer' ]; then
  echo '[*] composer exists'
else
  EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"
  
  if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
  then
      >&2 echo '[*] composer error: Invalid installer signature'
      rm composer-setup.php
      exit 1
  fi

  php composer-setup.php --quiet
  RESULT=$?
  rm composer-setup.php
  echo $RESULT 
fi


echo ''
echo '[*] installing dependencies'
echo '[*] 1 - npm i'
su $(whoami) -c "
source ~/.nvm/nvm.sh;
npm i;"

echo '[*] 2 - composer install'
su $(whoami) -c "
composer install;"
echo ''

echo ''
echo '[*] maintenancedb installation complete'
echo ''
echo $(date)
