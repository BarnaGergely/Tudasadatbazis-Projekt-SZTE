<?php
function dbConnect()
{
    // Create connection to Oracle
    $conn = oci_connect("ADMIN", "FatalWiki2023", "tudasbazis_high", 'AL32UTF8');
    if (!$conn) {
        $m = oci_error();
        echo $m, "\n";
        echo "Baj van";
        return null;
    } else {
        return $conn;
        echo "Adatbázis kapcsolat él.";
    }
}
