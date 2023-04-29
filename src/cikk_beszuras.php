<?php
include 'resources/functions/config.php'; 
<<<<<<< HEAD
//ha szerző akkor
if(isset($_POST['content']) && isset($_POST['cim']) && isset($_POST['keresoszavak'])){    
    $v = oci_parse($conn,"INSERT INTO CIKK(SZERZO_ID,LEKTOR_ID,CIM,TARTALOM,ALLAPOT) VALUES(:fid,NULL,:cim,:content,'in process')");
=======
// TODO: ha szerző akkor
if(isset($_POST['content']) && isset($_POST['cim'])){
    // Frissítés
    if(isset($_POST['id'])){
        $v = oci_parse($conn,"UPDATE CIKK SET CIM = '"+$_POST['cim']+"', TARTALOM = '"+$_POST['content']+"') WHERE id = "+$_POST['id']);
        oci_execute($v);
>>>>>>> a2bb04c86cf4b48c689ef1160f06b2daae0fe2d1

        $v = oci_parse($conn,"UPDATE KATEGORIA SET KATEGORIA = '".$_POST['kat']."' WHERE CIKK_ID = ".$_POST['id']);
        oci_execute($v);
    // létrehozás
    } else {
        $v = oci_parse($conn,"INSERT INTO CIKK(SZERZO_ID,LEKTOR_ID,CIM,TARTALOM,ALLAPOT) VALUES(:fid,NULL,:cim,:content,'in process')");

        oci_bind_by_name($v,":fid",$_SESSION['felhasznalo']['id']);
        oci_bind_by_name($v,":cim",$_POST['cim']);
        oci_bind_by_name($v,":content",$_POST['content']);
    
<<<<<<< HEAD
    oci_execute($array);

    $row = oci_fetch_array($array);

    oci_bind_by_name($v,":cid",$row[0]);
    oci_bind_by_name($v,":kat",$_POST['kat']);

    oci_execute($v);

//--------------------------------------------------------------

    $kulcsok = explode(',',$_POST['keresoszavak']);

    $array = oci_parse($conn, "SELECT MAX(id) from CIKK");
    oci_execute($array);
    $row = oci_fetch_array($array);
    for($i = 0;$i < count($kulcsok);$i++){
        $v = oci_parse($conn,"INSERT INTO KULCSSZO(CIKK_ID,KULCSSZO) VALUES(:cid,:kat)");


    
        oci_bind_by_name($v,":cid",$row[0]);
        oci_bind_by_name($v,":kat",$kulcsok[$i]);
        echo "<br>";
        oci_execute($v);

    }




=======
    
        oci_execute($v);
    
    
        $v = oci_parse($conn,"INSERT INTO KATEGORIA(CIKK_ID,KATEGORIA) VALUES(:cid,:kat)");
    
        $array = oci_parse($conn, "SELECT MAX(id) from CIKK");
        
        oci_execute($array);
    
        $row = oci_fetch_array($array);
    
        oci_bind_by_name($v,":cid",$row[0]);
        oci_bind_by_name($v,":kat",$_POST['kat']);
    
        oci_execute($v);
    
        
    }
>>>>>>> a2bb04c86cf4b48c689ef1160f06b2daae0fe2d1
    header("Location: cikk_iras.php");
}



?>