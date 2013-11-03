<?php
// update_student_courses.php: Adds or removes a course instance for the student
//      -Returns 1 on success
//      -Precondition: student_id and instance_id exist
//      -$student_id: the id of the student
//      -$instance_id: the id of the course instance
//      -$action: 'add' or 'remove'
// Zachary Thompson, Arthur Wuterich
// 11-1-13


DB_Connect();

// Get params
$student_id = Get('student_id', true);
$instance_id = Get('instance_id', true);
$action = Get('action', true);

if ($action != 'add' && $action != 'remove') {
    return ('Unsuppored action');
}

WhereAdd( $where, "student_id = $student_id" );
WhereAdd( $where, "course_instance_id = $instance_id");


// check if the course_instance is already associated with this student
$rows = count( DB_GetArray( DB_Query( "SELECT * FROM student_course_instance {$where}" ) ) );

if ($action == 'add') {

    if ($rows == 0) {
        DB_Query( "INSERT INTO student_course_instance (student_id, course_instance_id) 
                    VALUES ('{$student_id}','{$instance_id}')" );
    }
    else {
        return ('This course is already added');
    }
}

else if ($action == 'remove') {

    if ($rows > 0) {
        DB_Query ( "DELETE FROM student_course_instance ${where}" );
        $old_time_codes = DB_GetSingleArray( 
            DB_Query("
            SELECT DISTINCT time_code 
            FROM section_time_code 
            WHERE section_id IN (
                SELECT section.id 
                FROM course_instance, section 
                WHERE course_instance.id = course_instance_id 
                AND course_instance.id = {$instance_id})" 
        )
    );

    }
    else {
        return ('This course is already removed');
    }
}

// successful add or remove

// grab time codes for course instance
$cur_time_codes = DB_GetSingleArray( 
        DB_Query("
        SELECT DISTINCT time_code 
        FROM section_time_code 
        WHERE section_id IN (
            SELECT s.id 
            FROM course_instance AS ci, section AS s, student_course_instance AS sci
            WHERE ci.id = s.course_instance_id 
            AND ci.id = sci.course_instance_id
            AND sci.student_id = {$student_id})" 
        )
    );


// get availability
$avail = DB_GetSingleArray(
    DB_Query( "SELECT availability FROM student WHERE id={$student_id}" ) );

$avail_string = $avail[0];

// update availability string
UpdateAvailString( $avail_string, $cur_time_codes, $old_time_codes);
DB_Query( "UPDATE student SET availability=\"{$avail_string}\" WHERE id={$student_id}" );

return ('1');
