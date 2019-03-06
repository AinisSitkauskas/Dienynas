<?php
define("TIMESTAMP_YEAR_2000", "946684800");
define("TIMESTAMP_YEAR_2019", "1546300800");
$start = microtime(true);

class MarksGenerator {

    public function generateMarks($numberOfRows, $connection) {
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
        $connection->query($sqlQueryMarks);
    }

}

include("connection2.php");
$n = $argv[1];
$studentFirstNames = array("Jonas Dvivardis", "Petras", "Antanas", "Tomas", "Juozas", "Jurgis", "Mantas", "Danielius", "Stasys", "Algis");
$studentLastNames = array("Kazlauskas", "Jonaitis", "Petraitis", "Minderis", "Ignatavičius", "Kavaliauskas", "Sabonis", "Savickas", "Kesminas", "Adamkus");
$teachingSubjects = array("Lietuvių kalba", "Matematika", "Anglų kalba", "Istorija", "Fizika", "Biologija", "Chemija", "Kūno kultūra", "Technologijos");
$uniqueStudentNames = array();
$sqlQueryStudents = "INSERT INTO students (name, surname) VALUES";
for ($i = 0; $i < 10; $i++) {
    for ($j = 0; $j < 10; $j++) {
        $sqlQueryStudentsParts[] = "('$studentFirstNames[$i]', '$studentLastNames[$j]')";
        if (count($sqlQueryStudentsParts) == $n) {
            break;
        }
    }
    if (count($uniqueStudentNames) == $n) {
        break;
    }
}
$sqlQueryStudents .= implode(',', $sqlQueryStudentsParts);
$sqlQueryStudents .= ";";
$connection->query($sqlQueryStudents);
$sqlQuerySubject = "INSERT INTO teaching_subjects (teachingSubject) VALUES ";
for ($i = 0; $i < 9; $i++) {
    $sqlQuerySubjectParts[] = "('$teachingSubjects[$i]')";
    if (count($sqlQuerySubjectParts) == $n) {
        break;
    }
}
$sqlQuerySubject .= implode(',', $sqlQuerySubjectParts);
$sqlQuerySubject .= ";";
$connection->query($sqlQuerySubject);

$object = new MarksGenerator;
$m = (int) ($n / 5000);
if ($m > 0) {
    for ($j = 0; $j < $m; $j++) {
        $object->generateMarks(5000, $connection);
    }
}
$k = $n % 5000;
if ($k > 0) {
    $object->generateMarks($k, $connection);
}

$connection->close();
echo "Laikas: " . (microtime(true) - $start) . " s \n";
echo "Maksimali naudojama atminis: " . (memory_get_peak_usage(true) / 1024) . " Kb \n";
echo "Pazymiai sugeneruoti ! \n";
