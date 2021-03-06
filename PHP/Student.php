<?php
/**
 * Copyright Uros Jevtic. All rights reserved.
 */

class Student
{
    public $studentId;
    public $conn;

    /**
     * Student constructor.
     * @param $studentId
     * @param $conn
     */
    function __construct($studentId, $conn)
    {
        $this->studentId = $studentId;
        $this->conn = $conn;
    }

    /**
     * This function returns school board name by id
     * @param $boardId
     * @return mixed
     */
    function getBoardName($boardId)
    {
        $sql = "SELECT board_name FROM school_board WHERE board_id = $boardId";
        $data = mysqli_query($this->conn , $sql);
        $data = $data->fetch_assoc();
        $boardName = $data['board_name'];
        return $boardName;
    }

    /**
     * This function returns all grades from student
     * @return array
     */
    function getGrades()
    {
        $gradesArray = [];
        $sql = "SELECT grade FROM grade WHERE student_id = $this->studentId;";
        $data = mysqli_query($this->conn , $sql);
        while ($row = mysqli_fetch_row($data)) {
            array_push($gradesArray, $row[0]);
        }
        return array_values($gradesArray);
    }

    /**
     * In this function putting logic for CSM board condition
     * @return array
     */
    function CSM_board()
    {
        $sql = "SELECT AVG(grade) 'average_grade'FROM grade WHERE student_id = $this->studentId";
        $data = mysqli_query($this->conn , $sql);
        $data = $data->fetch_assoc();
        $averageGrade = $data['average_grade'];

        $array = $this->getGrades();

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

    /**
     * In this function putting logic for CSMB board condition
     * @return array
     */
    function CSMB_board()
    {
        $array = [];
        $sql = "SELECT grade FROM grade WHERE student_id = $this->studentId;";
        $data = mysqli_query($this->conn, $sql);

        while ($row = mysqli_fetch_row($data)) {
            array_push($array, $row[0]);
        }

        if (count($array) >= 2) {
            $highGrade = max($array);
        }
        else{
            $highGrade = $array[0];
        }


        if ($highGrade >= 8) {
            return ['result' => "Pass",
                'high_grade'=> $highGrade,
                'grades' => $array
            ];

        } else {
            return ['result' => "Fail",
                'high_grade'=> $highGrade,
                'grades' => $array
            ];
        }
    }

    /**
     * This function return grades, average grade and result if student Pass or not
     * @param $school_board
     * @return array
     */
    function Result($school_board)
    {
        if ($school_board == "CSM")
        {
            return $this->CSM_board();
        }
        elseif ($school_board == "CSMB")
        {
            return $this->CSMB_board();
        }
    }

    /**
     * This function saves data in XML file
     * @param $array
     */
    function toXML($array){

        $xml = new SimpleXMLElement('<student_info/>');

        $myXml = $xml->addChild('student');
        $myXml->addChild("id", $array['id']);
        $myXml->addChild("name", $array['name']);
        $myXml->addChild("list_of_grades", implode(',',$array['grades']));
        $myXml->addChild("high_hrade", $array['high_grade']);
        $myXml->addChild('Result', $array['result']);

        $fileName = $array['id'].'-Student_XML.xml';
        $xml->asXML($fileName);

    }

    /**
     * This function saves data in JSON file
     * @param $array
     * @return false|string
     */
    function toJSON($array){

        $json = json_encode($array, JSON_FORCE_OBJECT);
        return $json;

    }

    /**
     *This is a function that returns all the necessary student data and our score
     */
    function getStudentData()
    {
        $sql = "SELECT * FROM student where student_id = $this->studentId ;";
        $data = mysqli_query($this->conn , $sql);
        $data = $data->fetch_assoc();
        $student_id = $data['student_id'];
        $student_name = $data['student_name'];
        $school_board = $this->getBoardName($data['board_id']);
        $result = $this->Result($school_board);
        $studentGrades = $result['grades'];
        if (array_key_exists('high_grade', $result)) 
        {
            $highGrade = $this->Result($school_board)['high_grade'];
            $studentData = array(
                'id' => $student_id,
                'name' => $student_name,
                'grades' => $studentGrades,
                'high_grade' => $highGrade,
                'result' => $result
            );
            
        }
        else{
            $averageGrade = $this->Result($school_board)['average'];
            $studentData = array(
                'id' => $student_id,
                'name' => $student_name,
                'grades' => $studentGrades,
                'average' => $averageGrade,
                'result' => $result
            );
           
        }
        
        if ($school_board == "CSM")
        {
            $json = $this->toJSON($studentData);
            $myfile = fopen("$student_id-Student_JSON.json", "w") or die("Unable to open file!");
            fwrite($myfile, $json);
            fclose($myfile);
            echo "File saved as $this->studentId-Student_JSON.json";
        }
        elseif($school_board == "CSMB")
        {
            $this->toXML($studentData);
            echo "File saved as $this->studentId-Student_XML.xml";
        }

    }
}