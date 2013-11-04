use $PW_NAME;
BEGIN;
set @@foreign_key_checks = 0;

DROP TABLE IF EXISTS student_time_code;
DROP TABLE IF EXISTS section_time_code;
DROP TABLE IF EXISTS student_course_instance;
DROP TABLE IF EXISTS student;
DROP TABLE IF EXISTS section_professor;
DROP TABLE IF EXISTS section_time;
DROP TABLE IF EXISTS section;
DROP TABLE IF EXISTS professor;
DROP TABLE IF EXISTS course_instance;
DROP TABLE IF EXISTS course; 

CREATE TABLE course (
    id                  integer         NOT NULL PRIMARY KEY,
    subject             varchar(6)      NOT NULL,
    catalog_no          varchar(6)      NOT NULL,
    title               varchar(50)     NOT NULL,
    units               varchar(6)      NOT NULL,
    ge_code             varchar(8)
);

CREATE TABLE course_instance (
    id                  integer         NOT NULL PRIMARY KEY,
    course_id           integer         NOT NULL,
    FOREIGN KEY (course_id)
        REFERENCES course (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE section (
    id                  char(4)         NOT NULL PRIMARY KEY,
    course_instance_id  integer         NOT NULL,
    section_no          integer         NOT NULL,
    component           varchar(4),
    FOREIGN KEY (course_instance_id)
        REFERENCES course_instance (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE section_time (
    section_id          char(4)         NOT NULL,
    day                 varchar(3)      NOT NULL,
    start_time          char(4), 
    end_time            char(4),
    location            varchar(16),
    PRIMARY KEY (section_id, day, start_time, location),
    FOREIGN KEY (section_id)
        REFERENCES section(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE professor (
    id                  varchar(9)      NOT NULL PRIMARY KEY,
    fname               varchar(20)     NOT NULL,
    lname               varchar(20)     NOT NULL
);

CREATE TABLE section_professor (
    section_id          char(4)         NOT NULL,
    prof_id             varchar(9)      NOT NULL,
    PRIMARY KEY (section_id, prof_id),
    FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (prof_id) REFERENCES professor (id) ON UPDATE CASCADE
);

CREATE TABLE student (
    id                  integer         NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username            varchar(20)     NOT NULL UNIQUE,
    password            varchar(32)     NOT NULL,
    email               varchar(100)    NOT NULL UNIQUE,
    availability        varchar(168)    NOT NULL DEFAULT "111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111"
);

CREATE TABLE student_course_instance (
    student_id          integer         NOT NULL,
    course_instance_id  integer         NOT NULL,
    PRIMARY KEY (student_id, course_instance_id),
    FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (course_instance_id) REFERENCES course_instance (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE section_time_code (
    section_id          char(4)         NOT NULL,
    time_code           integer         NOT NULL,
    PRIMARY KEY (section_id, time_code),
    FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE student_time_code (
    student_id          integer         NOT NULL,
    time_code           integer         NOT NULL,
    PRIMARY KEY (student_id, time_code),
    FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE ON UPDATE CASCADE
);

set @@foreign_key_checks = 1;
COMMIT;
