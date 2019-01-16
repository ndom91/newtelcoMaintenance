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

#echo ''
#echo '[*] installing dependencies'
#echo '[*] 1 - npm i'
#npm i
#echo 'npm i'

#echo '[*] 2 - composer install'
#composer install
#echo 'composer install'
#echo ''

case "$1" in
	
	# production 
	prod)
	echo '[*] Copying production apache configs'
	sed -i "s|\[WORKING_DIR\]|$PWD|" configs/apache2/maintenancedb.production.conf
	cp configs/apache2/maintenancedb.production.conf /etc/apache2/sites-enabled/maintenancedb.conf
	;;

	# development 
	dev)
	echo '[*] Copying development apache configs'
	sed -i "s|\[WORKING_DIR\]|$PWD|" configs/apache2/maintenancedb.development.conf
	cp configs/apache2/maintenancedb.development.conf /etc/apache2/sites-enabled/maintenancedb-dev.conf
	echo '[*] Dev Domain: '
	echo '[*] sed -i "maintenance.newtelco.tech" into required files'
	sed -i 's/maintenance\.newtelco\.de/maintenance\.newtelco\.tech/g' addedit.php
	sed -i 's/maintenance\.newtelco\.de/maintenance\.newtelco\.tech/g' authenticate_google.php
	sed -i 's/maintenance\.newtelco\.de/maintenance\.newtelco\.tech/g' config.php
	sed -i 's/maintenance\.newtelco\.de/maintenance\.newtelco\.tech/g' incoming.php
	sed -i 's/maintenance\.newtelco\.de/maintenance\.newtelco\.tech/g' sessiondestroy.php
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

export NVM_DIR=/home/ndo/.nvm
export NVM_BIN=/home/ndo/.nvm/versions/node/v10.7.0/bin
export PATH=/home/ndo/.nvm/versions/node/v10.7.0/bin:$PATH
ln -s /home/ndo/.nvm/versions/node/v10.7.0/bin/node /usr/bin/node

echo ''
echo '[*] installing dependencies'
echo '[*] 1 - npm i'
su ndo -c "
source ~/.nvm/nvm.sh;
npm i;"
#echo 'npm i'

echo '[*] 2 - composer install'
su ndo -c "
composer install;"
#echo 'composer install'
echo ''

echo ''
echo '[*] maintenancedb installation complete'
echo ''
rm /usr/bin/node
echo $(date)
