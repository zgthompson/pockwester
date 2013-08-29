<?php
// insert_classes.php: Defines functions to dynamically insert information into a database
// Arthur Wuterich
// 8/28/13

// Constants  *** Should be moved to new file, true for all database constants and functions ***
// Database
define( 'DB_HOST_NAME', 'cs370tutoringapp.db.11456014.hostedresource.com' );
define( 'DB_USER_NAME', 'cs370tutoringapp');
define( 'DB_PASSWORD', 'Tutoring!!66' );
define( 'DB_DATABASE', 'cs370tutoringapp' );

// Connects to MySQL database  
function DB_Connect()
{
	$link = mysql_connect( DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_DATABASE );
	mysql_select_db ( DB_DATABASE );
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

// Will open a .txt file and insert each row of data into the an table
// $exclude: set of header values that will be excluded from the insertion
// $append: if set to false will empty the table first
// Precondition: A valid .txt file location
function InsertTextFile( $file, $table, $exclude = array(), $append = true )
{
	$link = DB_Connect();
	
	// Get the information from the .txt file
	$data = file_get_contents( $file );
		
	// If the .txt file does not provide any data, the database could not be connected, exit
	if( !$data || !$link )
	{
		return;
	}
	
	// Delete rows from the database if append is false
	if( !$append )
	{
		// Remove rows from table
		DB_Query( sprintf( 'DELETE FROM %s ', $table ) );
	}
	
	// Process the data from the text file
	$data = ProcessTextFile( $data );
	
	// Recieve the column headers from the database
	$headers = GetTableHeaders( $table, $exclude );
			
	// Insert each row into the database	
	foreach( $data as $row )
	{
		InsertRow( $row, $table, $headers );
	}
}

// Returns an array of the provided tables column titles
// Precondition: Connection to a MySQL database, a vaild table name
// $exclude: An array of headers that will be excluded from the result
function GetTableHeaders( $table, $exclude = array() )
{
	$result = array();

	// Get column data
	$headers = DB_Query( "SHOW COLUMNS FROM {$table}" );
	
	// Create array with column headers
	while( $row = mysql_fetch_array( $headers ) )
	{
		// If the row is to be excluded assign to empty
		$header = in_array( $row[0], $exclude )?'':$row[0];
		
		if( $header != '' )
		{
			$result[] = $header;
		}
	}
	
	return $result;
}

// Takes the contents of a file and returns an array with each line as a member
// Precondition: A valid string with new lines  
// Postcondtion: An array with each line formatted for processing
function ProcessTextFile( $data )
{
	// Break apart on new lines
	$data = explode("\n", $data);
	
	// Explode each member based on the delimiter
	foreach( $data as &$row )
	{
		$row = ProcessRow( $row );
	}
	
	// Return the array
	return $data;	
}

// Takes a string of data and formats it into an array for processing by the InsertRow function
// Precondition: A valid string object 
// Postcondition: An array object 
function ProcessRow( $data, $delimiter = ',' )
{
	// Remove quotes from the string
	$data = str_replace('"', "", $data);
	$data = str_replace("'", "", $data);
	return explode( $delimiter, $data );
}

// Inserts class data into database
// Precondition: A valid array with 11 members of strings
// Postcondition: Enters the row into the database
function InsertRow( $row, $table, $headers )
{
	// Exit the function if the input is in the wrong format
	if( !is_array( $row ) || count($row) != count($headers) )
	{
		return;
	}
		
	// Form query
	$fields = array( $table );
	
	// Get number of fields for c-style entry
	$keyS = ' %s' . str_repeat( ', %s', count( $headers )-1 );
	$valS = ' "%s"' . str_repeat( ', "%s"', count( $headers )-1 );
	
	// Merge the field and value array
	$fields = array_merge( $fields, $headers, $row );
	
	// Enter the row  *** Needs to be SQL escaped ***
	DB_Query( vsprintf( "INSERT INTO %s ( {$keyS} ) VALUES ( {$valS} )", $fields ) );
}
?>




















