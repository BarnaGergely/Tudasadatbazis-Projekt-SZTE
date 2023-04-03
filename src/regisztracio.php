<?php
include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');

if (isset($_POST["register"])) {    // miután az űrlapot elküldték...

    $hashelt_jelszo = password_hash($_POST['passworld'], PASSWORD_DEFAULT);
    $_POST['passworld'] = $hashelt_jelszo;

    $stid2 = oci_parse($conn, "SELECT id, felhasznalonev, email from felhasznalo WHERE email = '" . $_POST['email'] . "'");
    if (!$stid2) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $r = oci_execute($stid2);
    if (!$r) {
        $e = oci_error($stid2);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $row = oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_NULLS);
    if (!$row) { // ha még nem szerepel ilyen email cím az adatbázisban

        $stid = oci_parse($conn, 'INSERT INTO FELHASZNALO( Felhasznalonev, jelszo, email) ' . 'VALUES( :name, :passworld, :email)');
        if (!$stid) {
            $e = oci_error($conn);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        /* degug log
        echo $_POST['username'];
        echo $_POST['passworld'];
        echo $_POST['email'];
        */

        oci_bind_by_name($stid, ':name', $_POST['username']);
        oci_bind_by_name($stid, ':passworld', $_POST['passworld']);
        oci_bind_by_name($stid, ':email', $_POST['email']);

        oci_execute($stid);
        if (!$r) {
            $e = oci_error($stid2);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        oci_free_statement($stid);

        $success = "Sikeres regisztráció. Email: " . $_POST['email'] . " , Név: " . $_POST['username'];
    } else {
        $email_error = "Már használja valaki ezt az email címet. Válassz másikat!";
    }

    oci_free_statement($stid2);
}


?>
<div class="container">
    <h1>Regisztráció</h1>

    <?php
    if (isset($_SESSION["felhasznalo"])) {
        echo '<div class="alert alert-success" role="alert">
        ' . 'Már be vagy jelentkezve: ' . $_SESSION["felhasznalo"]["felhasznalonev"] . ' , ' . $_SESSION["felhasznalo"]["email"] . '
    </div>';
    }
    ?>
    <form action="regisztracio.php" method="POST" <?php if (isset($_SESSION["felhasznalo"])) echo 'hidden' ?>>

        <label for="exampleFormControlInput1" class="form-label">Email cím</label>
        <input type="email" class="form-control <?php
                                                if (isset($_POST['email'])) {
                                                    if (!isset($email_error)) {
                                                        echo 'is-valid"';
                                                    } else {
                                                        echo 'is-invalid"';
                                                    }
                                                    echo ' value="' . $_POST['email'] . '" ';
                                                }
                                                ?>" id="exampleFormControlInput1" name="email" placeholder="name@example.com" required>
        <?php
        if (!isset($email_error)) {
            echo '<div class="valid-feedback"> Rendben van! </div>';
        } else {
            echo '<div class="invalid-feedback">' . $email_error . '</div>';
        }
        ?>



        <label for="inputPassword5" class="form-label">Jelszó</label>
        <input type="password" id="inputPassword5" class="form-control <?php if (isset($_POST['email'])) echo 'is-valid" ' . 'value="' . $_POST['email'] . '" '; ?> aria-labelledby=" passwordHelpBlock" name="passworld" required>

        <label for="exampleFormControlInput3" class="form-label is-valid">Felhasználónév</label>
        <input type="text" class="form-control <?php if (isset($_POST['username'])) echo 'is-valid" ' . 'value="' . $_POST['username'] . '" '; ?>" id="exampleFormControlInput3" name="username" required>
        <button style="margin: 1rem;" type="submit" name="register" class="btn btn-primary" placeholder="Pista99">Regisztráció</button>
    </form>
</div>
<?php

if (isset($success)) {
    echo '<div class="alert alert-success" role="alert">
    ' . $success . '
  </div>';
}

require_once('resources/theme/footer.php');
?>