#!/bin/bash

# Run Drush site install

EMAIL=$1
TITLE=$2

echo "Installing rain_demo profile...\n"
drush site-install tyche_rain_gear install_configure_form.enable_update_status_module=NULL install_configure_form.enable_update_status_emails=NULL --verbose --yes --account-mail="$EMAIL" --site-name="$TITLE" --account-name superuser

echo "Clearing cache...\n"
passthru('drush cache-rebuild');
