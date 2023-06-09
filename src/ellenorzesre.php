<?php

include "resources/functions/config.php";

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

    <footer class="container">
        <hr>
        <ul>
            <?php
                $array = oci_parse($conn, "SELECT id,cim, lektor_id, szerzo_id from CIKK where allapot like 'in process'");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    $tools="";
                    if (isset($_SESSION["felhasznalo"]["rang"]["admin"]) || isset($_SESSION["felhasznalo"]["rang"]["lektor"])) {
                        $tools = " <a href='cikk_iras.php?id=" . $row["ID"] . "'><button>Módosítás</button></a> <a href='cikk_torles.php?id=" . $row["ID"] . "'><button>Törlés</button></a>";
                    } else {
                        if (isset($_SESSION["felhasznalo"]["rang"]["szerzo"])) {
                            if ($_SESSION["felhasznalo"]["id"] === $row["SZERZO_ID"]) {
                                $tools = " <a href='cikk_iras.php?id=" . $row["ID"] . "'><button>Módosítás</button></a>";
                            }
                        }
                    }

                    echo "<li>
                        <a href='cikk_tartalom.php?cikkID=".$row[0]."'>" . $row[1] ."</a> <a href='cikk_valid.php?cikkID=".$row[0]."'><button>PUBLIKÁLHATÓ</button></a>" . $tools . "</li>";

                    
                }

            ?>
        </ul>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

</html>