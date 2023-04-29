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

    <main class="container">
        <form action="cikk_kategoria.php" method="get">
            <div class="container">
                <select name="chK">
                    <?php

                    $array = oci_parse($conn, "SELECT kategoria from KATEGORIA GROUP BY kategoria");
                    oci_execute($array);
                    while ($row = oci_fetch_array($array)) {
                        $selected = "";
                        if (isset($_GET["chK"]) && ($_GET["chK"] == $row[0])) {
                            $selected = "selected";
                        }
                        echo "<option value='" . $row[0] . "'" . $selected . " > " . $row[0] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Kereses">
            </div>
        </form>
    </main>

    <footer class="container">
        <hr>
        <ul>
            <?php
            if (isset($_GET["chK"])) {
                $array = oci_parse($conn, "SELECT ID,cim, szerzo_id, lektor_id from CIKK where ID in (select cikk_ID from KATEGORIA where kategoria like '" . $_GET["chK"] . "' and allapot like 'publikus')");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    $tools="";
                    if (isset($_SESSION["felhasznalo"]["rang"]["admin"])) {
                        $tools = " <a href='cikk_iras.php?id=" . $row[0] . "'><button>Módosítás</button></a> <a href='cikk_torles.php?id=" . $row[0] . "'><button>Törlés</button></a>";
                    } else {
                        if (isset($_SESSION["felhasznalo"]["rang"]["szerzo"])) {
                            if ($_SESSION["felhasznalo"]["id"] === $row["SZERZO_ID"]) {
                                $tools = " <a href='cikk_iras.php?id=" . $row["ID"] . "'><button>Módosítás</button></a>";
                            }
                        }
                        if (isset($_SESSION["felhasznalo"]["rang"]["lektor"])) {
                            if ($_SESSION["felhasznalo"]["id"] === $row["LEKTOR_ID"]) {
                                $tools = " <a href='cikk_iras.php?id=" . $row["ID"] . "'><button>Módosítás</button></a>";
                            }
                        }
                    }
                    echo "<li><a href='cikk_tartalom.php?cikkID=" . $row[0] . "'>" . $row[1] . "</a>" . $tools . "</li>";
                }
            }

            ?>
        </ul>
    </footer>

    <?php include "includes/footer.php"; ?>
</body>

</html>