<?php
include 'resources/functions/config.php'; 

    $v = oci_parse($conn,"INSERT INTO MEGJEGYZES(CIKK_ID,TARTALOM,FELHASZNALO_ID) VALUES('".$_POST['cikkID']."','".$_POST['megjegyzes']."',".$_SESSION["felhasznalo"]["id"].")");
    oci_execute($v);


    header("Location: cikk_tartalom.php?cikkID=".$_POST["cikkID"]);




?>