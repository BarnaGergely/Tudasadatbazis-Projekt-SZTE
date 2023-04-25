<?php
include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');

$elokeszito = "DELETE FROM felhasznalo WHERE id=" . $_GET["id"];
$query = oci_parse($conn, $elokeszito);
$result = oci_execute($query);
if ($result) {
    oci_commit($conn); //*** Commit Transaction ***// 
    $success = "Felhasználó törölve.";
} else {
    $fail = "Hiba, Valószínűleg nincs ilyen felhasználó.";
}

?>


<div class="container">
    <h1><?php if (isset($_GET["id"])) echo $_GET["id"]; ?> ID-jú felhasználó törlése </h1>
</div>

<?php
if (isset($success)) {
    echo '<div class="alert alert-success" role="alert">
    ' . $success . '
  </div>';
}
if (isset($fail)) {
    echo '<div class="alert alert-danger" role="alert">
    ' . $fail . '
  </div>';
}
?>

<?php

require_once('resources/theme/footer.php');
?>