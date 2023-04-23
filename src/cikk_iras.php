<?php

    include "resources/functions/config.php"; 
    if(!$_SESSION["felhasznalo"]["rang"]["szerzo"]){
        header("Location: index.php");
        
    }

    include_once 'resources/functions/config.php';
    require_once('resources/theme/header.php');
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Írj saját cikket!</h1>

        <form action="cikk_beszuras.php" method="post">
            <p>
                <label for="cikkcim" >Cikk cime: </label>
                <input type="text" name="cim" id="cikkcim">
            </p>

            <p>
                <label for="kat" >Cikk kategóriája: </label>
                <input type="text" name="kat" id="kat">
            </p>
            <textarea name="content" class="form-control" rows="7"></textarea>

            <input class="btn btn-primary mt-3" type="submit" value="Küldés">
            
        </form>
        
    </div>
    <?php include "includes/footer.php"; ?>

</body>
</html>