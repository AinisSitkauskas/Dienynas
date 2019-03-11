<?php
$start = microtime(true);
include("classMarksgenerator.php");
$n = $argv[1];
$object = new MarksGenerator;
$object->generateMysqlRows($n);
echo "Laikas: " . (microtime(true) - $start) . " s \n";
echo "Maksimali naudojama atminis: " . (memory_get_peak_usage(true) / 1024) . " Kb \n";
echo "Pazymiai sugeneruoti ! \n";
