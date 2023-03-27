<?php include "resources/functions/config.php"; ?>

<!DOCTYPE html>
<html lang="hu" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tudásadatbázis</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="resources/styles/theme.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php

        include "includes/navbar.php";
        ?>
    </header>

    <main class="container">
        <h1>Felhasználók</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Felhasználónév</th>
                    <th scope="col">Email</th>
                    <th scope="col">Eszközök</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $array = oci_parse($conn, "SELECT id, felhasznalonev, email from felhasznalo");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    echo '<tr>';
                    echo '<td>' . $row[0] . '</td>';
                    echo '<td>' . $row[1] . '</td>';
                    echo '<td>' . $row[2] . '</td>';


                    echo '<td>' . '<form method="post">
                          <button  class="btn btn-outline-danger" type="submit" name="btn-delete" value="' . $row[0] . '">Törlés</button> 
                          <button class="btn btn-outline-primary" formmethod="get" name="id" value="' . $row[0] . '" formaction="felhasznalo-szerkeszto.php">Módosítás</button></form>' . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </main>

    <?php include "includes/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

</html>