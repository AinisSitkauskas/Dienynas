<?php
$start = microtime(true);
include("connection.php");
include("__CLASS__.Marks_Generator.php");
$object = new MarksGenerator($connection);
if (!empty($_GET['numberOfRows'])) {
    $object->generateMysqlRows($_GET['numberOfRows']);
    $connection->close();
}
include('views\fast_marks_generator_view.php');
