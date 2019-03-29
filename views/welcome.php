<!DOCTYPE html>
<html lang="lt">
    <head>
        <meta charset="UTF-8">
        <title>Dienynas</title>

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
        <h1> Sveiki, atvykę !  </h1>
        <form  method = "post" action="..\controlers\login.php" >
            <input type="submit" name="logout"  value="Atsijungti">
        </form>
        <?php
        if (!isset($_COOKIE['login'])) {
            header("Location: ../views/dienynas_login.php");
        }
        ?>
    </body>
</html>
