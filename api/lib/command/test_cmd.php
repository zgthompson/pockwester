<?php
// test_cmd: Stub for running custom commands from PWApi.
// Arthur Wuterich
// 9-11-13


DB_Connect();

DB_Query( "DELETE FROM USER_GROUP" );

print_r( DB_GetArray( DB_Query( "SELECT * FROM USER_GROUP WHERE GROUP_ID = 1" ) ));
return;


/* Code to take the sections from CLASS table and inset into SECTION table
$classes = DB_GetArray( DB_Query( "SELECT CLASS_ID, SECTION_NUMBER, SUBJECT, CATALOG_NUMBER, BUILDING, TIME, DAYS, INSTRUCTOR FROM CLASS" ) );


foreach( $classes as $row )
{
	DB_Query( "INSERT INTO SECTION 
				(SECTION_ID,SECTION_NUMBER,DEPARTMENT,COURSE_NUMBER,BUILDING,TIME,DAYS,INSTRUCTOR)
				VALUES 
				(\"{$row[0]}\",\"{$row[1]}\",\"{$row[2]}\",\"{$row[3]}\",\"{$row[4]}\",\"{$row[5]}\",\"{$row[6]}\",\"{$row[7]}\")" );
}
	
return( OutputFormatting( $classes ) );
*/

/* Code to take the sections from CLASS table and inset into COURSE table
$classes = DB_GetArray( DB_Query( "SELECT SUBJECT, CATALOG_NUMBER, TITLE, UNITS, TYPE FROM CLASS
								   GROUP BY SUBJECT, CATALOG_NUMBER" ) );


foreach( $classes as $row )
{
	DB_Query( "INSERT INTO COURSE 
				(DEPARTMENT,COURSE_NUMBER,TITLE,UNITS,TYPE)
				VALUES 
				(\"{$row[0]}\",\"{$row[1]}\",\"{$row[2]}\",\"{$row[3]}\",\"{$row[4]}\")" );
}
	
return( OutputFormatting( $classes ) );

*/

/*
// Code to take the sections from CLASS table and inset into COURSE table
$types = DB_GetArray( DB_Query( "SELECT CLASS_ID, TYPE FROM CLASS" ) );

foreach( $types as $type )
{

	DB_Query( "UPDATE SECTION SET TYPE = \"{$type[1]}\" WHERE SECTION_ID = \"{$type[0]}\"" );
}
	
return( OutputFormatting( $types ) );

*/

/* Added keys to new user_Details table
for( $i = 0; $i < 28; $i++ )
{
	DB_Query( "INSERT INTO USER_CONFIG (USER_ID) VALUES ({$i})" );	
}
*/




































?>	
