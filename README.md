Backend Developer Task (PHP):
You have to design a system that is responsible for the managing the grades for a list
of students.You should be able to calculate the average of the grades for a given student,
identify if he has passed or failed and return the student’s statistic.

Notes:
- Implement two school boards, CSM and CSMB
- CSM considers pass if the average is bigger or equal to 7 and fail otherwise. Returns
JSON file
- CSMB discards the lowest grade, if you have more than 2 grades, and considers pass if
his biggest grade is bigger than 8. Returns XML file
- Each student result, either XML or JSON, will contain the student id, name, list of
grades and final result (Fail or Pass)

______________________________________________________________________________________________________


-You need to restore the database backup 
-In the database there are students with the following ID 1,2,3,4


Examples:
-domain-of-your-app.test?student=1
-domain-of-your-app.test?student=2
-domain-of-your-app.test?student=3
-domain-of-your-app.test?student=4


-You have to change parameters in PHP/conn.php 
$servername = 'your_servername';
$username =  'your_username';
$password =  'your_password';
$database =  'quantox';

