<?php
include 'resources/functions/config.php'; 
// TODO: ha szerző akkor
if(isset($_POST['content']) && isset($_POST['cim'])){
    // Frissítés
    if(isset($_POST['id'])){
        $sql = "UPDATE CIKK SET CIM = '".$_POST['cim']."', TARTALOM = '".$_POST['content']."' WHERE id = ".$_POST['id'];
        echo($sql);
        $v = oci_parse($conn, $sql);
        oci_execute($v);

        $v = oci_parse($conn,"UPDATE KATEGORIA SET KATEGORIA = '".$_POST['kat']."' WHERE CIKK_ID = ".$_POST['id']);
        oci_execute($v);
    // létrehozás
    } else {
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
    
        //--------------------------------------------
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
    } 
    header("Location: cikk_iras.php");
}
?>






    








