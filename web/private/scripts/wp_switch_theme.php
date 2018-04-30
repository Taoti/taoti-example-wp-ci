<?php
// By default WordPress is going to try to use the latest twentyX theme, but all those are deleted. This will switch to the jp-base theme.
echo "Switching to the base theme...\n";
passthru('wp theme activate jp-base');
