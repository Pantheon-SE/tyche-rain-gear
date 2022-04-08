#!/bin/bash

# Run Drush site install

EMAIL=$1
TITLE=$2

echo "Installing rain_demo profile...\n"
drush site-install rain_demo install_configure_form.enable_update_status_module=NULL install_configure_form.enable_update_status_emails=NULL --verbose --yes --account-mail="$EMAIL" --site-name="$TITLE" --account-name superuser

echo "Importing default content...\n"
drush config-import --source="profiles/contrib/rain_demo/config/install" --yes

echo "Clearing cache...\n"
passthru('drush cache-rebuild');
