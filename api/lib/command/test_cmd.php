<?php
// test_cmd: Stub for running custom commands from PWApi *** THIS COMMAND DOES NOT HAVE DEFINED OUTPUT ***
// Arthur Wuterich
// 9-11-13


DB_Connect();

/* Code to take the sections from CLASS table and inset into SECTION table
$classes = DB_GetArray( DB_Query( "SELECT CLASS_ID, SUBJECT, CATALOG_NUMBER, BUILDING, TIME, DAYS, INSTRUCTOR FROM CLASS" ) );


foreach( $classes as $row )
{
	DB_Query( "INSERT INTO SECTION 
				(SECTION_NUMBER,DEPARTMENT,COURSE_NUMBER,BUILDING,TIME,DAYS,INSTRUCTOR)
				VALUES 
				(\"{$row[0]}\",\"{$row[1]}\",\"{$row[2]}\",\"{$row[3]}\",\"{$row[4]}\",\"{$row[5]}\",\"{$row[6]}\")" );
}
	
exit( OutputFormatting( $classes ) );
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
	
exit( OutputFormatting( $classes ) );
*/
?>	