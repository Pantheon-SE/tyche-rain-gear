<?php

// Get Pantheon site metadata
$req = pantheon_curl('https://api.live.getpantheon.com/sites/self/attributes', NULL, 8443);
$meta = json_decode($req['body'], true);
$title = $meta['label'];
$email = $_POST['user_email'];

// Install from profile.
echo "Installing tyche_rain_gear profile...\n";
passthru("./drush_install.sh $email $title &");

// // Import config changes.
echo "Importing Tyche default content...\n";
passthru('drush ycip tyche_rain_gear');
echo "Tyche content imported.\n";

passthru('drush cr');