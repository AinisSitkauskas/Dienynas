<?php
define("TIMESTAMP_YEAR_2000", "946684800");
define("TIMESTAMP_YEAR_2019", "1546300800");

class MarksGenerator {

    private $connection;

    function __construct() {
        include("parameters.php");
        $this->connection = new mysqli($serverName, $userName, $password, $dbName);
        if ($this->connection->connect_error) {
            echo "Prisijungti nepavyko: " . mysqli_connect_error();
        }
    }

    private function generateStudents($numberOfRows) {
        $studentFirstNames = array("Jonas Dvivardis", "Petras", "Antanas", "Tomas", "Juozas", "Jurgis", "Mantas", "Danielius", "Stasys", "Algis");
        $studentLastNames = array("Kazlauskas", "Jonaitis", "Petraitis", "Minderis", "Ignatavičius", "Kavaliauskas", "Sabonis", "Savickas", "Kesminas", "Adamkus");
        $uniqueStudentNames = array();
        $sqlQueryStudents = "INSERT INTO students (name, surname) VALUES";
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $sqlQueryStudentsParts[] = "('$studentFirstNames[$i]', '$studentLastNames[$j]')";
                if (count($sqlQueryStudentsParts) == $numberOfRows) {
                    break;
                }
            }
            if (count($uniqueStudentNames) == $numberOfRows) {
                break;
            }
        }
        $sqlQueryStudents .= implode(',', $sqlQueryStudentsParts);
        $sqlQueryStudents .= ";";
        $this->connection->query($sqlQueryStudents);
    }

    private function generateSubjects($numberOfRows) {
        $teachingSubjects = array("Lietuvių kalba", "Matematika", "Anglų kalba", "Istorija", "Fizika", "Biologija", "Chemija", "Kūno kultūra", "Technologijos");
        $sqlQuerySubject = "INSERT INTO teaching_subjects (teachingSubject) VALUES ";
        for ($i = 0; $i < 9; $i++) {
            $sqlQuerySubjectParts[] = "('$teachingSubjects[$i]')";
            if (count($sqlQuerySubjectParts) == $numberOfRows) {
                break;
            }
        }
        $sqlQuerySubject .= implode(',', $sqlQuerySubjectParts);
        $sqlQuerySubject .= ";";
        $this->connection->query($sqlQuerySubject);
    }

    private function generateMarks($numberOfRows) {
        $sqlQueryMarks = "INSERT INTO marks (idStudent, idSubject, mark, date) VALUES ";
        for ($i = 0; $i < $numberOfRows; $i++) {
            $dateTimestamp = rand(TIMESTAMP_YEAR_2000, TIMESTAMP_YEAR_2019);
            $mark = rand(1, 10);
            $date = date("Y-m-d", $dateTimestamp);
            $numberOfStudent = $i % 100 + 1;
            $numberOfSubject = $i % 9 + 1;
            $sqlQueryMarkParts[] = "('$numberOfStudent', '$numberOfSubject', '$mark', '$date')";
        }
        $sqlQueryMarks .= implode(',', $sqlQueryMarkParts);
        $sqlQueryMarks .= ";";
        $this->connection->query($sqlQueryMarks);
    }

    public function generateMysqlRows($numberOfRows) {
        $this->generateStudents($numberOfRows);
        $this->generateSubjects($numberOfRows);
        $m = (int) ($numberOfRows / 5000);
        if ($m > 0) {
            for ($j = 0; $j < $m; $j++) {
                $this->generateMarks(5000);
            }
        }
        $k = $numberOfRows % 5000;
        if ($k > 0) {
            $this->generateMarks($k);
        }
    }

    function __destruct() {
        $this->connection->close();
    }

}
