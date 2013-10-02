#!/bin/bash

# This script will install Moka's dependencies on Ubuntu
# This script is part of the Moka project.

clear
echo "This script will install Moka's dependencies on your Ubuntu system"

# Repository: ondrej's php5
sudo add-apt-repository --yes ppa:ondrej/php5

# Repository: official mongodb
sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
echo 'deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen' | sudo tee /etc/apt/sources.list.d/mongodb.list

# Go for it
echo "Updating software repositories..."
sudo apt-get update -q=2
echo "Installing required software (this may require some time)..."
sudo apt-get install --yes -q=2 wget build-essential sed unzip nano php5-cli php5-common php-pear php-mail php5-dev php5-fpm mongodb-10gen

# Install the mongo extension
echo "Installing the PHP Mongo extension..."
sudo pecl install mongo > /dev/null

# Add the mongo extension to the php.ini
if [ -f /etc/php5/cli/php.ini ];then
	echo "Setting up PHP CLI..."
	sudo sed -i '/mongo\.so/d' /etc/php5/cli/php.ini
	sudo -- bash -c "echo 'extension=mongo.so' >> /etc/php5/cli/php.ini"
	sudo killall php 2> /dev/null
fi
if [ -f /etc/php5/apache2/php.ini ];then
	echo "Setting up PHP Apache2 module..."
	sudo sed -i '/mongo\.so/d' /etc/php5/apache2/php.ini
	sudo -- bash -c "echo 'extension=mongo.so' >> /etc/php5/apache2/php.ini"
	sudo service apache2 restart
fi
if [ -f /etc/php5/fpm/php.ini ];then
	echo "Setting up PHP PHP5-FPM module..."
	sudo sed -i '/mongo\.so/d' /etc/php5/fpm/php.ini
	sudo -- bash -c "echo 'extension=mongo.so' >> /etc/php5/fpm/php.ini"
	sudo service php5-fpm restart
fi

echo "Restarting mongo database server..."
sudo service mongodb restart

echo "Done. All the dependencies should now be installed"