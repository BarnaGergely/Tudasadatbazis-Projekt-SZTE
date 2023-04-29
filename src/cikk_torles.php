<?php
include 'resources/functions/config.php'; 
// TODO: ha szerző akkor
if(isset($_GET['id']) && isset($_SESSION["felhasznalo"]["rang"]["admin"])){
    $v = oci_parse($conn,"DELETE FROM CIKK WHERE ID = ".$_GET['id']);
    oci_execute($v);

    header("Location: cikk_kategoria.php");
} else {
    echo "Nincs jogod törölni vagy nem adtál meg ID-t.";
}



?>