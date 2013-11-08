<?php
//	pw.cfg.php: Defines constants and configuration variables for pw web interface
//	9-17-13
//	Arthur Wuterich

// System Variables
define( 'AVAL_LENGTH', 168 );
define( 'PW_VERSION', 'V0.4.0' );

// Flags
define( 'FLAG_NONE', 0 );
define( 'FLAG_LFG', 1 );

// Path constants
define( 'LIB_PATH', '/pockwester/web/lib/' );
define( 'IMG_PATH', '/pockwester/web/image/' );
define( 'SRC_PATH', '/pockwester/web/src/' );
define( 'CSS_PATH', '/pockwester/web/style/' );
define( 'JAV_PATH', '/pockwester/web/js/'  );
define( 'THM_PATH', '/pockwester/web/theme/'  );

// API http location
define( 'PWAPI_URL', 'http://arthurwut.com/pockwester/api/' );
define( 'PWAPI_TIMEOUT', 5 );

// Useful constants
define( 'NOW', time() );

// Template variables
define( 'DEFAULT_CONTENT', 'home'	);
define( 'INFO_CONTENT'	 , 'setup_user' );
define( 'LOGIN_PAGE'     , 'login'	);
define( 'LOGOUT_PAGE'	 , 'logout'	);
define( 'HEADER_FILE'	 , 'head.php' 	);
define( 'PW_BAR_FILE'	 , 'pw_bar.php' );
define( 'BOUNCE_QUICK'	 , .5 			);
define( 'BOUNCE_NORMAL'	 , 2 			);

// Themes
define( 'DEFAULT_THEME', 'pw.global.css' );

// Source files that are considered public and do not need a login to access
$PUBLIC_SOURCE_FILES = array ( 'new_user', 'logout', LOGIN_PAGE, LOGOUT_PAGE, 'help_user' );

?>
