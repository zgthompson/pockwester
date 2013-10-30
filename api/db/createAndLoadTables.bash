#! /bin/bash

export CSV_FILE=campus_2013_Report.csv

echo 'Creating DB schema starts'
sed -i 's/$PW_NAME/'$PW_NAME'/' apiDBSchema.sql
mysql --host=$PW_HOST --password=$PW_PASS --user=$PW_USER < apiDBSchema.sql
sed -i 's/'$PW_NAME'/$PW_NAME/' apiDBSchema.sql
echo 'Creating DB schema ends'

python generateBaseTables.py

for dataFile in course.sql professor.sql course_instance.sql section.sql \
    section_professor.sql section_time.sql; do
    echo "Poplulating table $(echo $dataFile | sed 's/\.sql//')."
    mysql --host=$PW_HOST --password=$PW_PASS --user=$PW_USER < $dataFile
    echo "Poplulating table $(echo $dataFile | sed 's/\.sql//') completed."
done

