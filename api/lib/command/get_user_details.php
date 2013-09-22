<?php
// get_user_details.php: Will return the information about a user
// 9-21-13
// Arthur Wuterich


$user_email = Get( 'user_email', false );	
$user_id = Get( 'user_id', false );
$user_name = Get( 'user_name', false );

// If non of the information above is provided then error out
if( $user_email == '' && $user_id == '' && $user_name == '' )
{
	exit( '-1' );
}

DB_Connect();

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

$user_data = DB_GetSingleArray( DB_Query( "SELECT NAME, EMAIL FROM USER WHERE {$where}" ) );

if( count( $user_data ) <= 0 )
{
	exit( '-1' );
}

exit( OutputFormatting(  $user_data ) );
	
	
?>