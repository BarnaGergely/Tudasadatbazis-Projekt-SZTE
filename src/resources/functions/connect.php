<?php
// Create connection to Oracle - rossz
$conn = oci_connect("ADMIN", "FatalWiki2023", "tudasbazis_high");
if (!$conn) {
   $m = oci_error();
   echo $m, "\n";
   exit;
} else {
   print "Connected to Oracle!";
}
// Close the Oracle connection
oci_close($conn);
