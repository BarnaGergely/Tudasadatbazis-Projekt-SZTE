<?php
include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');


if (isset($_POST["login"])) {    // miután az űrlapot elküldték...

    $stid = oci_parse($conn, "SELECT id, felhasznalonev, jelszo, email from felhasznalo WHERE email = '" . $_POST['email'] . "'");
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
    if (!$row) {
        $login_error = "Nincs ilyen email cím regisztrálva";
    } else if (password_verify($_POST["passworld"], $row["JELSZO"])) {

        $_SESSION["felhasznalo"] = [
            "felhasznalonev" => $row["FELHASZNALONEV"],
            "id" => intval($row["ID"]),
            "email" => $_POST["email"],
            "rang" => []
        ];

        // adatbázisban lévő rangok lekrédezése
        $array = oci_parse($conn, "SELECT jog_nev from jog where felhasznalo_id = " . $_SESSION["felhasznalo"]["id"]);
        oci_execute($array);
        while ($row = oci_fetch_array($array)) {
            $_SESSION["felhasznalo"]["rang"][$row[0]] = true;
        }
        oci_free_statement($array);

        $success = "Sikeres bejelentkezés! Üdvözlünk " . $_SESSION["felhasznalo"]["felhasznalonev"];
    } else {
        $login_error = "Nincs ilyen jelszó és email páros";
    }

    oci_free_statement($stid);
}


?>
<div class="container">
    <h1>Bejelentkezés</h1>

    <?php
    if (isset($_SESSION["felhasznalo"])) {
        echo '<div class="alert alert-success" role="alert">
            ' . 'Már be vagy jelentkezve: ' . $_SESSION["felhasznalo"]["felhasznalonev"] . ' , ' . $_SESSION["felhasznalo"]["email"] . '
            </div>';
    }
    ?>
    <form action="bejelentkezes.php" method="POST" <?php if (isset($_SESSION["felhasznalo"])) echo 'hidden' ?>>
        <label for="exampleFormControlInput1" class="form-label">Email cím</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="name@example.com" <?php if (isset($_POST['email'])) echo 'value="' . $_POST['email'] . '" '; ?>>
        <label for="inputPassword5" class="form-label">Jelszó</label>
        <input type="password" id="inputPassword5" class="form-control" aria-labelledby="passwordHelpBlock" name="passworld" <?php if (isset($_POST['passworld'])) echo 'value="' . $_POST['passworld'] . '" '; ?>>
        <button style="margin: 1rem;" type="submit" name="login" class="btn btn-primary">Bejelentkezés</button>
    </form>
</div>

<?php
if (isset($success)) {
    echo '<div class="alert alert-success" role="alert">
    ' . $success . '
  </div>';
}

if (isset($login_error)) {
    echo '<div class="alert alert-danger" role="alert">
    ' . $login_error . '
  </div>';
}

require_once('resources/theme/footer.php');
?>