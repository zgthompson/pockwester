<?php
//	pw.cfg.php: Defines constants and configuration variables for pw web interface
//	9-17-13
//	Arthur Wuterich

// Path constants
define( 'LIB_PATH', 'lib/' );
define( 'IMG_PATH', 'img/' );
define( 'SRC_PATH', 'src/' );
define( 'CSS_PATH', 'css/' );

// API http location
define( 'PWAPI_URL', 'http://arthurwut.com/pockwester/api/' );
define( 'PWAPI_TIMEOUT', 5 );

// Useful constants
define( 'NOW', time() );

// Page defining constants
// *** Testing this method of including header information ... might need to be refactored ***
define( 'DOC_TYPE', '<!DOCTYPE html>' );
define( 'GLOBAL_CSS', '<link rel="stylesheet" type="text/css" href="'.CSS_PATH.'pw.global.css'.'">' );
define( 'GLOBAL_TITLE', '<title>Forge:Test</title>' );

define( 'GLOBAL_HEAD', '<head>' . GLOBAL_CSS . GLOBAL_TITLE . '</head>' );

// Set the default landing page if there is not routing information
define( 'DEFAULT_CONTENT', 'home.php' );

// Define valid source files for index to pull
$VALID_SOURCE_FILES = array( 'search_classes.php', 'home.php' );

?>