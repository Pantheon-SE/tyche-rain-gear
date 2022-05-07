<?php

// Import content changes.
echo "Importing default content...\n";
passthru('drush ycip tyche_rain_gear');
echo "Importing Tyche content...\n";

// // Clear all cache
echo "Rebuilding cache.\n";
passthru('drush cr');
