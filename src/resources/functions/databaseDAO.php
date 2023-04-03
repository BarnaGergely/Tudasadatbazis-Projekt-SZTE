<?php
function dbConnect()
{
    // Create connection to Oracle
    $conn = oci_connect("ADMIN", "FatalWiki2023", "tudasbazis_high", 'AL32UTF8');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        return null;
    } else {
        return $conn;
    }
}
