<?php

DB_Connect();

// Get params
$student_id = Get('student_id', false);
$instance_id = Get('instance_id', false);
$action = Get('action', false);

if ( isset($student_id) && isset($instance_id) && isset($action) )
{
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

            return ( '1');
        }
    }
    else if ($action == 'remove') {
        DB_Query ( "DELETE FROM student_course_instance ${where}" );

        return ('1');
    }
    else {
        return ('Unsuppored action');
    }
}
else {
    return ('Must provide student_id, instance_id and an action');
}

