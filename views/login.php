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

        <h1>Dienynas </h1><br>
        <form  method = "post" action="index.php?controller=login&action=login" >
            Vartotojo vardas:<br>
            <input type="text" name="userName">
            <br>
            Slaptažodis:<br>
            <input type="password" name="password">
            <br><br>
            <input type="submit"  value="Prisijungti">
        </form>
    </body>
</html>
