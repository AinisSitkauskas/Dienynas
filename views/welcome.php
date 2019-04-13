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
        <form  method = "post" action="index.php?controller=login&action=logout" >
            <input type="submit" name="logout"  value="Atsijungti">
        </form>
    </body>
</html>
