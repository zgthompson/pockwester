<?php
//	pw.cfg.php: Defines constants and configuration variables for pw web interface
//	9-17-13
//	Arthur Wuterich

// Path constants
define( 'LIB_PATH', 'lib/' );
define( 'IMG_PATH', 'img/' );
define( 'SRC_PATH', 'src/' );
define( 'CSS_PATH', 'css/' );
define( 'JAV_PATH', 'js/'  );

// API http location
define( 'PWAPI_URL', 'http://arthurwut.com/pockwester/api/' );
define( 'PWAPI_TIMEOUT', 5 );

// Useful constants
define( 'NOW', time() );

// Mapping for day to values
$DAY_VALUE = array
(
	'M' => 0,
	'T' => 1,
	'W' => 2,
	'R' => 3,
	'F' => 4,
	'S' => 5,
	'U' => 6
);

$VALUE_DAY = array
(
	0 => 'Monday',
	1 => 'Tuesday',
	2 => 'Wednesday',
	3 => 'Thursday',
	4 => 'Friday',
	5 => 'Saturday',
	6 => 'Sunday'
);

// Page defining constants
// *** Testing this method of including header information ... might need to be refactored ***
define( 'DOC_TYPE', '<!DOCTYPE html>' );
define( 'GLOBAL_CSS', '<link rel="stylesheet" type="text/css" href="'.CSS_PATH.'pw.global.css'.'">' );
define( 'JQUERY', '<script src="'.JAV_PATH.'jquery-1.10.2.js"></script>' );
define( 'GLOBAL_JS', '<script src="'.JAV_PATH.'pw.global.js"></script>' );
define( 'GLOBAL_TITLE', '<title>Forge:Test</title>' );

define( 'GLOBAL_HEAD', '<head>' . GLOBAL_CSS . GLOBAL_TITLE . JQUERY . GLOBAL_JS . '</head>' );

// Set the default landing page if there is not routing information
define( 'DEFAULT_CONTENT', 'home.php' );

// Define valid source files for index to pull
$VALID_SOURCE_FILES = array( 'search_classes.php', 'home.php', 'calc_schecule.php' );

?>