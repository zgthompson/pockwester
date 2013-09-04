<?
// Database: Defines functions for php database connections
// Arthur Wuterich
// 8/28/13

// Database constants are defines in the .htaccess file

// Connects to MySQL database  
function DB_Connect()
{
	$link = mysql_connect( $_SERVER['DB_HOST_NAME'], $_SERVER['DB_USER_NAME'], $_SERVER['DB_PASSWORD'] );
	mysql_select_db( $_SERVER['DB_DATABASE'] );
	return $link;
}

// Executes a query on the connected database
// Precondition: A valid SQL query
// Side effect: Executes the SQL query
function DB_Query( $query )
{
	$result = mysql_query( $query );
		
	// Show error if available
	if (!$result) {
		echo mysql_error(), '<BR/>';
	}	
	
	return $result;
}

// Returns a row of data from a query result
// Precondition: A valid MySql query result object
function DB_GetRow( &$result )
{
	return mysql_fetch_row( $result );
}

// Returns a 2d array with all of the elements
// Precondition: A valid MySql query result object
// Postcondition: A 2d array with all query information
function DB_GetArray( &$result )
{
	$array = array();

	while( $row = DB_GetRow( $result ) )
	{
		$array[] = $row;
	}
	
	return $array;
}

?>