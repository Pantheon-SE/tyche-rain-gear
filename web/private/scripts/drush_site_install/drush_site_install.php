<?php

// Get Pantheon site metadata
$req = pantheon_curl('https://api.live.getpantheon.com/sites/self/attributes', NULL, 8443);
$meta = json_decode($req['body'], true);
$title = $meta['label'];
$email = $_POST['user_email'];

// Install from profile.
echo "Installing rain_demo profile...\n";
passthru('drush site-install rain_demo install_configure_form.enable_update_status_module=NULL install_configure_form.enable_update_status_emails=NULL --verbose --yes --account-mail="' . $email . '" --site-name="' . $title . '" --account-name superuser');