<?php
// insert_classes.php: Defines functions to insert class information into a database
// Arthur Wuterich
// 8/28/13

// Constants  *** Could be moved to another file ***
// Database
define( 'DB_HOST_NAME', 'cs370tutoringapp.db.11456014.hostedresource.com' );
define( 'DB_USER_NAME', 'cs370tutoringapp');
define( 'DB_PASSWORD', 'Tutoring!!66' );
define( 'DB_DATABASE', 'cs370tutoringapp' );

define( 'DB_CLASS_TABLE', 'CLASS' );

$DB_LINK = null;

// Columns in table  *** Convience only; can be dynamically generated ***
define( 'DB_CLASS_TABLE_ROWS', 11 );

// Connects to MySQL database  *** Should be moved to new file, true for all database functions ***
function DB_Connect()
{
	mysql_connect( DB_HOST_NAME, DB_USER_NAME, DB_PASSWORD, DB_DATABASE );
	mysql_select_db ( DB_DATABASE );
	return;
}

// Executes a query on the connected database
// Precondition: A valid SQL query
// Side effect: Executes the SQL query
function DB_Query( $query )
{
	$result = mysql_query( $query );
		
	if (!$result) {
		echo mysql_error(), '<BR/>';
	}	
	
	return;
}

// Will open a .txt file and insert each row of data into the class database
// -append: if set to false will empty the table first
// Precondition: A valid .txt file location
function InsertClassTextFile( $file, $append = true )
{
	DB_Connect();
	
	// Get the information from the .txt file
	$data = file_get_contents( $file );
		
	// If the .txt file does not provide any data, the database could not be connected, exit
	if( $data == false )
	{
		return;
	}
	
	// Delete rows from the database if append is false
	if( !$append )
	{
		// Remove rows from table
		DB_Query( sprintf( 'DELETE FROM %s ', DB_CLASS_TABLE ) );
	}
	
	// Process the data from the text file
	$data = ProcessTextFile( $data );
		
	// Insert each row into the database	
	foreach( $data as $row )
	{
		InsertClassRow( $row );
	}
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

// Takes a string of data and formats it into an array for processing by the InsertClassRow function
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
function InsertClassRow( $row )
{
	// Exit the function if the input is in the wrong format
	if( !is_array( $row ) || count( $row ) != DB_CLASS_TABLE_ROWS )
	{
		return;
	}
	
	// Form query  *** REFACTOR because this tightly binds this function to the table data ***
	$fields = array( DB_CLASS_TABLE, 'CLASS_ID', 'SUBJECT', 'CATALOG_NUMBER', 'SECTION_NUMBER', 'TITLE', 'UNITS', 'TYPE', 'DAYS', 'TIME', 'BUILDING', 'INSTRUCTOR' );
	
	// Get number of fields
	$keyS = ' %s' . str_repeat( ', %s', count( $fields )-2 );
	$valS = ' "%s"' . str_repeat( ', "%s"', count( $fields )-2 );
	
	// Merge the field and value array
	$fields = array_merge( $fields, $row );
	
	// Enter the row	
	DB_Query( vsprintf( "INSERT INTO %s ( {$keyS} ) VALUES ( {$valS} )", $fields ) );
}
?>




















