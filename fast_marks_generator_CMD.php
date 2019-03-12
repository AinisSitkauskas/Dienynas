<?php
$start = microtime(true);
include("connection.php");
include("__CLASS__.Marks_Generator.php");
$n = $argv[1];
$object = new MarksGenerator($connection);
$object->generateMysqlRows($n);
$connection->close();
echo "Laikas: " . (microtime(true) - $start) . " s \n";
echo "Maksimali naudojama atminis: " . (memory_get_peak_usage(true) / 1024) . " Kb \n";
echo "Pazymiai sugeneruoti ! \n";
