<?php
//	get_user_details.php: Will return the information about a user
//	[$user_email]: Email to reference against
//	[$user_id]: ID number to reference against
//	[$user_name]: Name to reference against
//	9-21-13
//	Arthur Wuterich

DB_Connect();

$user_email = Get( 'user_email', false );	
$user_id = Get( 'user_id', false );
$user_name = Get( 'user_name', false );

// If non of the information above is provided then error out
if( $user_email == '' && $user_id == '' && $user_name == '' )
{
	return( '-1' );
}

// Construct where clause
$where = '';

if( $user_email )
{
	$where .= " EMAIL = \"{$user_email}\"";
}

if( $user_id )
{
	if( $where != '' ){ $where .= ' AND'; }
	$where .= " UID = {$user_id}";
}

if( $user_name )
{
	if( $where != '' ){ $where .= ' AND'; }
	$where .= " NAME = \"{$user_name}\"";
}

$user_data = DB_GetSingleArray( DB_Query( "SELECT username, email FROM student WHERE {$where}" ) );

if( count( $user_data ) <= 0 )
{
	return( '-1' );
}

return( OutputFormatting(  $user_data ) );
	
	
?>