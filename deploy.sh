#!/usr/bin/bash

#-----------------------------
# Colors
#-----------------------------
YELLOW='\033[0;33m'
GREEN='\033[0;32m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m'

check_dependencies()
{
    if ! command -v composer &> /dev/null
    then
        echo "Composer could not be found, please install it first."
        exit 1
    fi
    if ! command -v npm &> /dev/null
    then
        echo "npm could not be found, please install it first."
        exit 1
    fi
    if ! command -v php &> /dev/null
    then
        echo "php could not be found, please install it first."
        exit 1
    fi
    if ! command -v mysql &> /dev/null
    then
        echo "mysql could not be found, please install it first."
        exit 1
    fi
}
setup_database()
{
    # input root password mysql
    read -s -p "Enter MySQL root password: " MYSQL_ROOT_PASSWORD
    # check root password mysql
    if ! mysql -u root -p$MYSQL_ROOT_PASSWORD -e "SELECT 1" &> /dev/null
    then
        echo "MySQL root password is incorrect."
        exit 1
    fi

    # auto create database random with prefix jadicms_
    DB_NAME="jadicsms_$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 8 | head -n 1)"
    echo "Creating database $DB_NAME..."
    mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE DATABASE $DB_NAME;"
    echo "Database $DB_NAME created."

    # auto create user random with prefix user_
    DB_USER="user_$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 8 | head -n 1)"
    echo "Creating user $DB_USER..."
    mysql -u root -p$MYSQL_ROOT_PASSWORD -e "CREATE USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_USER';"
    echo "User $DB_USER created."

    # grant all privileges to user
    echo "Granting privileges to user $DB_USER..."
    mysql -u root -p$MYSQL_ROOT_PASSWORD -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';"
    echo "Privileges granted to user $DB_USER."

    # flush privileges
    echo "Flushing privileges..."
    mysql -u root -p$MYSQL_ROOT_PASSWORD -e "FLUSH PRIVILEGES;"
    echo "Privileges flushed."

    # assign to .env
    sed -i "s/DB_DATABASE=.*$/DB_DATABASE=$DB_NAME/" .env
    sed -i "s/DB_USERNAME=.*$/DB_USERNAME=$DB_USER/" .env
    sed -i "s/DB_PASSWORD=.*$/DB_PASSWORD=$DB_USER/" .env
    sed -i "s/DB_CONNECTION=.*$/DB_CONNECTION=mysql/" .env
}
setup_gemini_apikey()
{
    read -s -p "Enter Gemini API Key: " GEMINI_API_KEY
    sed -i "s/GEMINI_API=.*$/GEMINI_API_KEY=$GEMINI_API_KEY/" .env
}

setup_app()
{
    echo "Installing dependencies..."
    composer install
    npm install
    npm run build
    cp .env.example .env
    read -n "APP URL: "; APP_URL
    sed -i "s/APP_URL=.*$/APP_URL=$APP_URL/" .env
    read -n "APP NAME: "; APP_NAME
    sed -i "s/APP_NAME=.*$/APP_NAME=$APP_NAME/" .env
    php artisan key:generate
    setup_gemini_apikey
    setup_database
    php artisan migrate --seed
    php artisan storage:link
    php artisan shield:setup
}
setup_permission()
{
    echo "Setting permission..."
    chmod -R 777 storage
    chmod -R 777 bootstrap/cache
    echo "Permission set."
}
check_dependencies
setup_app
setup_permission