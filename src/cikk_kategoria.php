<?php

include "resources/functions/connect.php";

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

    <main>
        <form action="cikk_kategoria.php" method="get">
            <div class="container">
                <div class="chooseCategory">
                    <select name="chK">
                        <?php
                        
                        $array = oci_parse($conn, "SELECT kategoria from KATEGORIA");
                        oci_execute($array);
                        while($row=oci_fetch_array($array))
                        {
                            echo "<option value='".$row[0]."'> ".$row[0]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" value="szia">
            </form>
    </main>

    <footer>
        <ul>
            <?php
            if(isset($_GET["chK"])){
                echo "SELECT cim from CIKK where ID in (select cikk_ID from KATEGORIA where kategoria like '".$_GET["chK"]."')";
                $array = oci_parse($conn, "SELECT cim from CIKK where ID in (select cikk_ID from KATEGORIA where kategoria like '".$_GET["chK"]."')");
                oci_execute($array);
                while($row=oci_fetch_array($array))
                {
                    echo "<li>".$row[0]."</li>";    
                }
            }
            
            ?>
        </ul>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

</html>