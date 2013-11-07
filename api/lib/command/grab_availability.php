<?php
// grab_availability.php: Pulls the students availability string from the database
//      -Returns the student availability string or an error message
//      -Precondition: student exists
//      -$student_id: the id of the current student
// Zachary Thompson, Arthur Wuterich
// 11-1-13

DB_Connect();

// Get like
$student_id = Get('student_id', true);

// get the availability
$avail = DB_GetSingleArray(
    DB_Query( "SELECT availability FROM student WHERE id={$student_id}" ) );

// if user does not exist return error message
if ( empty($avail) )
{
    return("Invalid user id");
}

$avail_string = $avail[0];

// else return the availability string
return ( $avail_string );

?>
