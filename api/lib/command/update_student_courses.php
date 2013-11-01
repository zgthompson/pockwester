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

WhereAdd( $where, "student_id = $student_id" );
WhereAdd( $where, "course_instance_id = $instance_id");

if ($action == 'add') {
    $rows = DB_GetArray( 
        DB_Query( "SELECT * FROM student_course_instance {$where}" ) );

    if ( count($rows) > 0 ) {
        return ( 'This course is already added' );
    }
    else {
        DB_Query( "
            INSERT 
            INTO 
                student_course_instance (student_id, course_instance_id) 
            VALUES 
                ('{$student_id}','{$instance_id}')" );

        return ('1');
    }
}
else if ($action == 'remove') {
    DB_Query ( "DELETE FROM student_course_instance ${where}" );

    return ('1');
}
else {
    return ('Unsuppored action');
}

