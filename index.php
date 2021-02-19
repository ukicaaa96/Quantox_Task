<?php

include_once 'PHP/conn.php';
include 'PHP/Student.php';


$StudentId = $_REQUEST['student'];

$student = new Student($id, $conn);
$array = $student->getStudentData();








