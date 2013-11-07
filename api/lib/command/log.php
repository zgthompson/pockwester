<?php
// log.php: Will return the profile logging data
// [$limit]: Limits the amount of data returnd
// [$task]: returns tasks only like $task
// 11-6-13
// Arthur Wuterich

// http://stackoverflow.com/questions/4746079/how-to-create-a-html-table-from-a-php-array
function build_table($array){
	$headerRow = true;
    // start table
    $html = '<table style=" width:100%; ">';
    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
			if( $headerRow )
			{
				$html .= "<td><strong>{$value2}</strong></td>";
			}
			else
			{
				$html .= "<td>{$value2}</td>";
			}
        }
		$headerRow = false;
        $html .= '</tr>';
    }
    // finish table and return it
    $html .= '</table>';
    return $html;
}

DB_Connect();

$limit = Get( 'limit', false, 1000 );
$task = Get( 'task', false, '' );

echo build_table( DB_GetArray( DB_Query( "SELECT 'id', 'ip', 'api task', 'seconds', 'start', 'end', 'date' UNION ( SELECT * FROM API_LOG AS B WHERE B.COMMAND LIKE \"%{$task}%\" ORDER BY B.LOG_ID DESC LIMIT {$limit} )" ) ) );

?>