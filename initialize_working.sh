#!/usr/bin/env bash

#Updating and Installing Composer
composer install

#Initialising Migration 
php artisan migrate --force

#Initialising symbolic link between the public directory and storage directory
php artisan storage:link

#Generate artisan key
php artisan key:generate


# Check if the software is ready to run on online server
source .env
echo "START_HOSTING_ON_CLOUD: $START_HOSTING_ON_CLOUD"

case "$START_HOSTING_ON_CLOUD" in
  [yes]*)
    echo "Initialising the script..."
    chmod +x ./serve.sh # Enabling script
    ./serve.sh # Running script
    ;;
  *)
    # User input on to run the software on loopback interface
    read -p "Do you want to run the script? (Y/y for yes, N/n for no): " val
    case "$val" in
      [Yy]*)
        echo "Initialising the script..."
        chmod +x ./serve.sh # Enabling script
        ./serve.sh # Running script
        ;;
      [Nn]*)
        echo "Okay!..have a good day"
        echo ""
        exit 1
        ;;
      *)
        echo "Invalid input. Please enter Y/y or N/n."
        exit 1
        ;;
    esac 
    ;;
esac






