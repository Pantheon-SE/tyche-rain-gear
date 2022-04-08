<?php

// Import config changes.
echo "Importing default content...\n";
passthru('drush config-import --source profiles/contrib/rain_demo/config/install -y');

// Clear all cache
echo "Rebuilding cache.\n";
passthru('drush cr');