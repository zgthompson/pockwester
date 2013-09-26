<?php
//	pw.cfg.php: Defines constants and configuration variables for pw web interface
//	9-17-13
//	Arthur Wuterich

// System Variables
define( 'AVAL_LENGTH', 168 );
define( 'PW_VERSION', 'V0.2.1' );

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

// Template variables
define( 'DEFAULT_CONTENT', 'home.php'	);
define( 'LOGIN_PAGE'     , 'login.php'	);
define( 'LOGOUT_PAGE'	 , 'logout.php'	);
define( 'HEADER_FILE'	 , 'head.php' 	);
define( 'PW_BAR_FILE'	 , 'pw_bar.php' );
define( 'BOUNCE_QUICK'	 , .5 			);
define( 'BOUNCE_NORMAL'	 , 2 			);

// Themes
define( 'DEFAULT_THEME', 'pw.global.css' );

// Source files that are considered public and do not need a login to access
$PUBLIC_SOURCE_FILES = array ( 'new_user.php', 'logout.php', LOGIN_PAGE, LOGOUT_PAGE, 'help_user.php' );

?>
