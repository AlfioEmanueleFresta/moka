#!/bin/bash

# This script will help the user along the configuration of the app
# This script is part of the Moka project.

echo "This script will help you configure your installation"

# Database name
echo "DATABASE: Your database name [default: test]"
read dbname
if [[ $dbname = '' ]];then
	dbname = 'test'
fi

# Email host
echo "EMAIL: SMTP Host [default: localhost]"
read smtphost
if [[ $smtphost = '' ]];then
	smtphost = 'localhost'
fi

# Email username
echo "EMAIL: SMTP Username [default: (none)]"
read smtpuser

# Email password
echo "EMAIL: SMTP Password [default: (none)]"
read -s smtppass

echo "Updating the configuration files..."

# Copy blank configuration files
cp core/configuration/sample/database.php core/configuration/
cp core/configuration/sample/emails.php core/configuration/

# Make the substitutions...
sed -i "s/DBNAME/$dbname/g" core/configuration/database.php
sed -i "s/SMTP_HOST/$smtphost/g" core/configuration/emails.php
sed -i "s/SMTP_USERNAME/$smtpuser/g" core/configuration/emails.php
sed -i "s/SMTP_PASSWORD/$smtppass/g" core/configuration/emails.php

echo "Done. Moka correctly installed"