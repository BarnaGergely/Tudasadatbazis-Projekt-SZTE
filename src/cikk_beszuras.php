<?php
include 'resources/functions/config.php'; 
//ha szerző akkor
if(isset($_POST['content']) && isset($_POST['cim'])){    
    $v = oci_parse($conn,"INSERT INTO CIKK(SZERZO_ID,LEKTOR_ID,CIM,TARTALOM,ALLAPOT) VALUES(:fid,NULL,:cim,:content,'in process')");

    oci_bind_by_name($v,":fid",$_SESSION['felhasznalo']['id']);
    oci_bind_by_name($v,":cim",$_POST['cim']);
    oci_bind_by_name($v,":content",$_POST['content']);


    oci_execute($v);


    $v = oci_parse($conn,"INSERT INTO KATEGORIA(CIKK_ID,KATEGORIA) VALUES(:cid,:kat)");

    $array = oci_parse($conn, "SELECT MAX(id) from CIKK");
    
    oci_execute($array);

    $row = oci_fetch_array($array);

    oci_bind_by_name($v,":cid",$row[0]);
    oci_bind_by_name($v,":kat",$_POST['kat']);

    oci_execute($v);

    header("Location: cikk_iras.php");
}



?>