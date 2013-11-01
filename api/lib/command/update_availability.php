<?php
// update_availability.php: Updates a student's availability string
//      -Returns 1 on success or an error message
//      -Precondition: student exists
//      -$student_id: the id of the current student
//      -$avail_string: the availability string
// Zachary Thompson, Arthur Wuterich
// 11-1-13

DB_Connect();

// Get like
$student_id = Get('student_id', true);
$avail_string = Get('avail_string', true);

// check if user exists
$avail = DB_GetSingleArray(
    DB_Query( "SELECT * FROM student WHERE id={$student_id}" ) );

// if user does not exist return error message
if ( empty($avail) )
{
    return("Invalid user id");
}

DB_Query( "UPDATE student SET availability=\"{$avail_string}\" WHERE id={$student_id}" );

return ('1');
?>
