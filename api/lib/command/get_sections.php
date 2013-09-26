<?php
//	get_sections.php: Returns the sections from the database
//  [$last_update]: Will return only the sections that have been updated after this time
// 9-21-13
// Arthur Wuterich

$last_update = Get( 'last_update', false );

DB_Connect();

$make = array ( 'COURSE_ID' => array( 'DEPARTMENT', 'COURSE_NUMBER' ) );
$remove = array( 'UPDATED', 'COURSE_NUMBER', 'DEPARTMENT' );
$combine = array( 'DAYS' => 'TIME' );
$rename = array( 'DAYS' => 'TIME' );

// Return assoc tables
$assoc = true;

// Filter based on provided unix timestamp
if( isset($last_update) && is_numeric($last_update) )
{
	$sections = DB_GetArray( DB_Query( "SELECT * from SECTION where {$last_update} < unix_timestamp(UPDATED)" ), $assoc );	
}
else
{
	$sections = DB_GetArray( DB_Query( "SELECT * from SECTION" ), $assoc );		
}

MakeKeys( $sections, $make );
CombineKeys( $sections, $combine );

RemoveKeys( $sections, $remove );

RenameKeys( $sections, $rename );

FormatAssocKeys( $sections );

return( OutputFormatting( array( 'sections' => $sections ) ) );



?>