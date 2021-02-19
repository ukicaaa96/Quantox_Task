<?php

include_once 'PHP/conn.php';
include 'PHP/Student.php';


$studentId = $_REQUEST['student'];

$student = new Student($studentId, $conn);
$array = $student->getStudentData();








