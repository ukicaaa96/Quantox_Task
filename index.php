<?php

include_once 'PHP/conn.php';

function getBoardName($boardId, $conn){
    $sql = "SELECT board_name FROM school_board WHERE board_id = $boardId";
    $data = mysqli_query($conn , $sql);
    $data = $data->fetch_assoc();
    $boardName = $data['board_name'];
    return $boardName;
}

function getGrades($conn, $studentId){
    $gradesArray = [];
    $sql = "SELECT grade FROM grade WHERE student_id = $studentId;";
    $data = mysqli_query($conn , $sql);
    while ($row = mysqli_fetch_row($data)) {
        array_push($gradesArray, $row[0]);
    }

    return array_values($gradesArray);

}

function CSM_board($conn, $studentId){
    $sql = "SELECT AVG(grade) 'average_grade'FROM grade WHERE student_id = $studentId";
    $data = mysqli_query($conn , $sql);
    $data = $data->fetch_assoc();
    $averageGrade = $data['average_grade'];

    $array = getGrades($conn, $studentId);

    if ($averageGrade >= 7){
        return ['result' => "Pass",
            'average'=> $averageGrade,
            'grades' => $array
        ];
    }
    else{
        return ['result' => "Fail",
            'average'=> $averageGrade,
            'grades' => $array
        ];
    }
}

function CSMB_board($conn, $studentId)
{
    $array = [];
    $sql = "SELECT grade FROM grade WHERE student_id = $studentId;";
    $data = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_row($data)) {
        array_push($array, $row[0]);
    }

    if (count($array) >= 2) {
        $min = min($array);
        $array = array_diff($array, [$min]);
    }
        $sum = array_sum($array);
        $countGrades = count($array);

        $average = $sum / $countGrades;

        if ($average >= 8) {
            return ['result' => "Pass",
                    'average'=> $average,
                    'grades' => $array
            ];

        } else {
            return ['result' => "Pass",
                'average'=> $average,
                'grades' => $array
            ];
        }

}

function Result($school_board, $studentId, $conn)
{
    if ($school_board == "CSM"){
       return CSM_board($conn, $studentId);
    }
    elseif ($school_board == "CSMB"){
        return CSMB_board($conn, $studentId);
    }


}

function getStudentData($conn, $request){
    $sql = "SELECT * FROM student where student_id = $request;";
    $data = mysqli_query($conn , $sql);
    $data = $data->fetch_assoc();
    $student_id = $data['student_id'];
    $student_name = $data['student_name'];
    $school_board = getBoardName($data['board_id'], $conn);
    $studentGrades = Result($school_board, $student_id, $conn)['grades'];
    $result = Result($school_board, $student_id, $conn)['result'];
    $averageGrade = Result($school_board, $student_id, $conn)['average'];
    $studentData = array(
        'id' => $student_id,
        'name' => $student_name,
        'school_board'=> $school_board,
        'grades' => $studentGrades,
        'average' => $averageGrade,
        'result' => $result
    );

    return $studentData;

}

echo json_encode(getStudentData($conn, 1), JSON_FORCE_OBJECT);
echo '<br>';
echo json_encode(getStudentData($conn, 2), JSON_FORCE_OBJECT);
echo '<br>';
echo json_encode(getStudentData($conn, 3), JSON_FORCE_OBJECT);
echo '<br>';
echo json_encode(getStudentData($conn, 4), JSON_FORCE_OBJECT);
echo '<br>';





