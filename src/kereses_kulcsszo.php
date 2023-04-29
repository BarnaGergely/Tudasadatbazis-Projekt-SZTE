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
        <form action="kereses_kulcsszo.php" method="get">
            <label for="k">Keress kulcsszó alapján</label>
            <input type="text" name="kulcsszo" id="k">
        </form>
        <hr>
        <ul>
            <?php
            if(isset($_GET["kulcsszo"])){

                $array = oci_parse($conn, "select cikk_id,cikk.cim from kulcsszo inner join cikk on cikk.id = kulcsszo.cikk_id where kulcsszo like '".$_GET["kulcsszo"]."'");
                
                oci_execute($array);
                
                $i=0;
                while ($row = oci_fetch_array($array)) {
                    echo "<li><a href='cikk_tartalom.php?cikkID=" . $row[0] . "'>" . $row[1] . "</a></li>";
                    $i++;
                }

                if($i == 0){
                    echo "Nincs ilyen kulcsszavú cikk.";
                }
            }
            

            ?>
        </ul>
    </footer>



    <?php include "includes/footer.php"; ?>
</body>

</html>