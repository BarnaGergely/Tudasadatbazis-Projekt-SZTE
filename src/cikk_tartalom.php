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
        <?php
            if(isset($_GET["cikkID"])){
                $array = oci_parse($conn, "SELECT cim,tartalom from CIKK where ID = ".$_GET["cikkID"]);
                oci_execute($array);

            $row = oci_fetch_array($array);

            echo "<h1>" . $row[0] . "</h1>";
            echo "<p>" . $row[1]->load() . "</p>";
        }

        ?>
    </main>



    <?php include "includes/footer.php"; ?>
</body>

</html>