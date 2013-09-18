<?php
//	pw.functions.php: Global functions for use in pw web interface
//	9-17-13
//	Arthur Wuterich

// Directly include the cfg file if not already loaded
require_once( 'lib/pw.cfg.php' );

// Returns true if the page is a valid source file
// Precondition: $page is a valid string and the pw.cfg.php file has been included
function IsPageValid( $page )
{
	global $VALID_SOURCE_FILES;
	return in_array( $page, $VALID_SOURCE_FILES );
}

// Displays the content page provided
// Precondtion: Assumes that $page is a valid content page and pw.cfg.php has been included
// Postcondition: $page php will be executed and html displayed
function GetPage( $page )
{
	// Header information
	echo DOC_TYPE, '<html>', GLOBAL_HEAD, '<body>';
	
	// Body content
	include SRC_PATH . $page;
	
	// Closing tags
	echo '</body>', '</html>';
}

// Runs a PWAPI task
// Precondition: Valid PWAPI task, and API url is defined in pw.cfg.php
//  $post: Post array that will be built and sent with the api request
function PWTask( $apiTask, $post = array() )
{

	// Add the apiTask to the post array as well as the apikey
	$post['apitask'] = $apiTask;
	$post['apikey'] = $_SERVER['API_APIKEY'];
	
	// Open url link
	$link = curl_init();
	
	// Options
	curl_setopt($link, CURLOPT_URL, PWAPI_URL);
	curl_setopt($link, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($link, CURLOPT_CONNECTTIMEOUT, PWAPI_TIMEOUT);
	

	curl_setopt($link, CURLOPT_POSTFIELDS, $post);
	
	// Get the data
	$data = curl_exec($link);
	
	// Be nice and clean up
	curl_close($link);
	
	return $data;
}

?>