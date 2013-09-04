<?php
// cmds.php: 	Outputs a list of commands 
//				 -Expects api.php to call this file
// Arthur Wuterich
// 9-3-13

$result = '';

// Add each command
foreach( $API_COMMANDS as $cmd )
{
	$result .= "{$cmd} ";
}

exit( $result );
?>