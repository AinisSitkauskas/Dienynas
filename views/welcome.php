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
        <h1> Sveikas, sugrįžęs <?=$_SESSION['userName'] ?>.</h1>
        <form  method = "post" action="index.php?controller=user&action=register" >
            Registruoti naują vartotoją:
            <br>
            <input type="submit"  value="Registruoti">
        </form>
        <form  method = "post" action="index.php?controller=user&action=delete" >
            Ištrinti vartotoją:
            <br>
            <input type="submit"  value="Ištrinti">
        </form>
        <form  method = "post" action="index.php?controller=login&action=logout" >
            <br>
            <br>
            <input type="submit" name="logout"  value="Atsijungti">
        </form>
    </body>
</html>
