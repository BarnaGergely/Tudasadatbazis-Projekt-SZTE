<?php
include 'resources/functions/config.php'; 

if(!$_SESSION["felhasznalo"]["rang"]["lektor"]){
    header("Location: index.php");
    
}
//ha szerző akkor
if(isset($_GET['cikkID'])){

    
    $v = oci_parse($conn,"UPDATE CIKK set allapot = 'publikus', lektor_ID = :lid where ID = :id");
    
    oci_bind_by_name($v,":id",$_GET["cikkID"]);
    oci_bind_by_name($v,":lid",$_SESSION["felhasznalo"]["id"]);



    oci_execute($v);
    header("Location: ellenorzesre.php");
}



?>