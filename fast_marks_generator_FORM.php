<?php
$start = microtime(true);
include("classMarksgenerator.php");
$object = new MarksGenerator;
if (!empty($_GET['numberOfRows'])) {
        $object->generateMysqlRows($_GET['numberOfRows']);
        include('views\fast_marks_generator_view.php');
        die();
}
include('views\fast_marks_generator_view.php');
