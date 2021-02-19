<?php

include_once 'PHP/conn.php';
include 'PHP/Student.php';
//
//$id = $_REQUEST['student'];
//
//
//function getBoardName($boardId, $conn){
//    $sql = "SELECT board_name FROM school_board WHERE board_id = $boardId";
//    $data = mysqli_query($conn , $sql);
//    $data = $data->fetch_assoc();
//    $boardName = $data['board_name'];
//    return $boardName;
//}
//
//function getGrades($conn, $studentId){
//    $gradesArray = [];
//    $sql = "SELECT grade FROM grade WHERE student_id = $studentId;";
//    $data = mysqli_query($conn , $sql);
//    while ($row = mysqli_fetch_row($data)) {
//        array_push($gradesArray, $row[0]);
//    }
//
//    return array_values($gradesArray);
//
//}
//
//function CSM_board($conn, $studentId){
//    $sql = "SELECT AVG(grade) 'average_grade'FROM grade WHERE student_id = $studentId";
//    $data = mysqli_query($conn , $sql);
//    $data = $data->fetch_assoc();
//    $averageGrade = $data['average_grade'];
//
//    $array = getGrades($conn, $studentId);
//
//    if ($averageGrade >= 7){
//        return ['result' => "Pass",
//            'average'=> $averageGrade,
//            'grades' => $array
//        ];
//    }
//    else{
//        return ['result' => "Fail",
//            'average'=> $averageGrade,
//            'grades' => $array
//        ];
//    }
//}
//
//function CSMB_board($conn, $studentId)
//{
//    $array = [];
//    $sql = "SELECT grade FROM grade WHERE student_id = $studentId;";
//    $data = mysqli_query($conn, $sql);
//
//    while ($row = mysqli_fetch_row($data)) {
//        array_push($array, $row[0]);
//    }
//
//    if (count($array) >= 2) {
//        $min = min($array);
//        $array = array_diff($array, [$min]);
//    }
//        $sum = array_sum($array);
//        $countGrades = count($array);
//
//        $average = $sum / $countGrades;
//
//        if ($average >= 8) {
//            return ['result' => "Pass",
//                    'average'=> $average,
//                    'grades' => $array
//            ];
//
//        } else {
//            return ['result' => "Pass",
//                'average'=> $average,
//                'grades' => $array
//            ];
//        }
//
//}
//
//function Result($school_board, $studentId, $conn)
//{
//    if ($school_board == "CSM"){
//       return CSM_board($conn, $studentId);
//    }
//    elseif ($school_board == "CSMB"){
//        return CSMB_board($conn, $studentId);
//    }
//
//
//}
//
//function getStudentData($conn, $request){
//    $sql = "SELECT * FROM student where student_id = $request;";
//    $data = mysqli_query($conn , $sql);
//    $data = $data->fetch_assoc();
//    $student_id = $data['student_id'];
//    $student_name = $data['student_name'];
//    $school_board = getBoardName($data['board_id'], $conn);
//    $studentGrades = Result($school_board, $student_id, $conn)['grades'];
//    $result = Result($school_board, $student_id, $conn)['result'];
//    $averageGrade = Result($school_board, $student_id, $conn)['average'];
//    $studentData = array(
//        'id' => $student_id,
//        'name' => $student_name,
//        'grades' => $studentGrades,
//        'average' => $averageGrade,
//        'result' => $result
//    );
//
//    if ($school_board == "CSM"){
//        $json = toJSON($studentData);
//        $myfile = fopen("$student_id-Student_JSON.txt", "w") or die("Unable to open file!");
//        fwrite($myfile, $json);
//        fclose($myfile);
//        echo "File saved as $student_id-Student_JSON.txt";
//
//    }
//    elseif($school_board == "CSMB"){
//        toXML($studentData);
//        echo "File saved as $student_id-Student_XML.xml";
//    }
//
//}
//
//function toXML($array){
//
//    $xml = new SimpleXMLElement('<student_info/>');
//
//        $array1 = $xml->addChild('student');
//        $array1->addChild("id", $array['id']);
//        $array1->addChild("name", $array['name']);
//        $array1->addChild("list_of_grades", implode(',',$array['grades']));
//        $array1->addChild("average", $array['average']);
//        $array1->addChild('Result', $array['result']);
//
//        $fileName = $array['id'].'-Student_XML.xml';
//        $xml->asXML($fileName);
//
//}
//
//function toJSON($array){
//
//    $json = json_encode($array, JSON_FORCE_OBJECT);
//    return $json;
//
//}
//getStudentData($conn, $id);
//echo '<br>';
//getStudentData($conn, 2);
//echo '<br>';
//getStudentData($conn, 3);
//echo '<br>';
//getStudentData($conn, 4);



$id = $_REQUEST['student'];

$student = new Student($id, $conn);
$array = $student->getStudentData();








