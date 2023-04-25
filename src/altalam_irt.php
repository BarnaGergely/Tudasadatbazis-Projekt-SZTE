<?php

include "resources/functions/config.php";
if(!$_SESSION["felhasznalo"]["rang"]["szerzo"]){
    header("Location: index.php");
    
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


    <footer class="container">
        <hr>
        <ul>
            <?php
                $array = oci_parse($conn, "SELECT ID,cim,allapot from CIKK where SZERZO_ID = :id");

                oci_bind_by_name($array,":id",$_SESSION["felhasznalo"]["id"]);
                
                oci_execute($array);
                

                while ($row = oci_fetch_array($array)) {
                    echo "<li>".$row[1]."</li>";
                }
            

            ?>
        </ul>
    </footer>



    <?php include "includes/footer.php"; ?>
</body>

</html>