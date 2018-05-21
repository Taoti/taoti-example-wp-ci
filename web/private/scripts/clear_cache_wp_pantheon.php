<?php

// This command requires the Pantheon Advanced Page Cache to be installed. It ought to be an MU plugin, so this should be good.
// https://wordpress.org/plugins/pantheon-advanced-page-cache/

exec('wp pantheon cache purge-all');