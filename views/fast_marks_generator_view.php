<!DOCTYPE html>
<html lang="lt">
    <head>
        <meta charset="UTF-8">
        <title>Mokomojų dalykų pažymių generatorius</title>

        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <?php
        if (empty($_GET['numberOfRows'])) {
            ?>
            <h1> Mokomojų dalykų pažymių gneratorius </h1>
            <form  method = "get" >
                Įveskite generuojamų pažymių skaičių:<br>
                <input type="text" name="numberOfRows">
                <br><br>
                <input type="submit"  value="Generuoti">
            </form>
            <?php
        }
        if (!empty($_GET['numberOfRows'])) {
            ?>
            <p>Pažymiai sugeneruoti!</p>
            <p>Programos veikimo trukmė:    <?= microtime(true) - $start ?> s </p>
            <p>Maksimali naudojama atmintis:    <?= memory_get_peak_usage(true) / 1024 ?> Kb </p>
            <?php
        }
        ?>
    </body>
</html>
