<?php
/*
  Plugin Name: Taoti Core
  Description: Adds necessary plugins like ACF and Timber.
  Version: 1.01
  Author: James Pfleiderer
  Author URI: https://www.taoti.com/
*/

require WPMU_PLUGIN_DIR.'/disable-emojis/disable-emojis.php';
require WPMU_PLUGIN_DIR.'/jp/jp.php';
require WPMU_PLUGIN_DIR.'/advanced-custom-fields-pro/acf.php';
require WPMU_PLUGIN_DIR.'/timber-library/timber.php';
require WPMU_PLUGIN_DIR.'/wp-redis/wp-redis.php';
require WPMU_PLUGIN_DIR.'/pantheon-advanced-page-cache/pantheon-advanced-page-cache.php';
