<?php
include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');

session_unset();          // munkamenet-változók kiürítése ($_SESSION egy üres tömb lesz)
session_destroy();        // munkamenet törlése

$success = "Sikeres kijelentkezés.";
?>
<div class="container">
  <?php
  if (isset($success)) {
    header("Location: index.php");
  }
  ?>

</div>

<?php

require_once('resources/theme/footer.php');
?>