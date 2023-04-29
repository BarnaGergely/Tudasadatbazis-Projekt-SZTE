<?php include "resources/functions/config.php";

if (!$_SESSION["felhasznalo"]["rang"]["admin"]) {
    header("Location: index.php");
}

if (isset($_POST["javitas"])) {
    $stmt2 = oci_parse($conn, "BEGIN REPAIRJOG(); END;");
    oci_execute($stmt2);
}

?>

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
        <form method="post"><button class="btn btn-outline-primary" formmethod="get" name="javitas" value="1" formaction="felhasznalok.php">Jogosultságok javítása</button></form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Felhasználónév</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rang</th>
                    <th scope="col">Aktivitás</th>
                    <th scope="col">Eszközök</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $array = oci_parse($conn, "SELECT id, felhasznalonev, email from felhasznalo");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    $activity = 0;
                    $stmt = oci_parse($conn, "BEGIN :result := AKTIVITAS(:userid); END;");
                    oci_bind_by_name($stmt, ':userid', $row[0]);
                    oci_bind_by_name($stmt, ':result', $activity, PDO::PARAM_INT);
                    oci_execute($stmt);

                    echo '<tr>';
                    echo '<td>' . $row[0] . '</td>';
                    echo '<td>' . $row[1] . '</td>';
                    echo '<td>' . $row[2] . '</td>';
                    echo '<td>';
                    $rangLista = oci_parse($conn, "SELECT jog_nev from jog where jog.felhasznalo_id = " . $row[0]);
                    oci_execute($rangLista);
                    while ($jogRow = oci_fetch_array($rangLista)) {
                        echo $jogRow[0]  . ', ';
                    }

                    echo '</td>';
                    echo '<td>' . $activity[0] . '</td>';


                    echo '<td>' . '<form method="post">
                          <button class="btn btn-outline-danger" formmethod="get" name="id" value="' . $row[0] . '" formaction="felhasznalo-torlo.php">Törlés</button>
                          <button class="btn btn-outline-primary" formmethod="get" name="id" value="' . $row[0] . '" formaction="felhasznalo-szerkeszto.php">Módosítás</button></form>' . '</td>';
                    echo '</tr>';
                }
                oci_free_statement($stmt);
                oci_free_statement($array);
                oci_free_statement($rangLista);
                ?>
            </tbody>
        </table>
    </main>

    <?php include "includes/footer.php"; ?>


</body>

</html>