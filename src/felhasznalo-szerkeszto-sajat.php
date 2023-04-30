<?php
include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');

if (!isset($_SESSION["felhasznalo"])) {
    header("Location: index.php");
}

// TODO: rangok lekérdezése az adatbázisból
$osszesrang = [
    0 => "olvaso",
    1 => "szerzo",
    2 => "lektor",
    3 => "admin",
];

// alapértelmezett értékek betöltése
if (isset($_GET["id"]) && !empty($_GET["id"])) {

    // adatbázisban lévő felhasználó adatok lekérdezése
    if (!isset($data) || isset($_POST["save"])) {
        $stid2 = oci_parse($conn, "SELECT id, felhasznalonev, email, jelszo from felhasznalo WHERE id = '" . $_GET["id"] . "'");
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
            $id_error = "Nem szerepel ilyen ID-jú felhasználó az adatbáziban: " . $_GET["id"];
        } else {
            $data = ["id" => intval($row["ID"]), "email" => $row["EMAIL"], "felhasznalonev" => $row["FELHASZNALONEV"], "jelszo" => $row["JELSZO"]];
        }

        oci_free_statement($stid2);
    }


    // Űrlapba bele rakni az adatokat
    if (!isset($_POST["email"])) {
        $_POST['username'] = $data["felhasznalonev"];
        $_POST['email'] = $data["email"];
        // Jelszo nem kell, azt nem lehet vissza fejteni, ezert mindig újra meg kell adni
    }

    // Űrlap beküldésekor mentés
    if (isset($_POST["save"])) {    // miután az űrlapot elküldték...

        // Email cím ugyan az mint a jelenlegi felhasználóé vagy nem használja még másik felhasználó
        $email_verifed = false;
        if ($_POST['email'] === $data['email']) {
            $email_verifed = true;
        } else {

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
                $email_verifed = true;
            } else {
                $email_error = "Már használja valaki ezt az email címet. Válassz másikat!";
            }

            oci_free_statement($stid2);
        }

        if ($email_verifed) {
            // régi jelszó megegyezik az adatbázisban lévő jelszóval
            if (password_verify($_POST['passworld'], $data["jelszo"])) {
                $hashelt_ujjelszo = password_hash($_POST['newpassworld'], PASSWORD_DEFAULT);

                $stid = oci_parse($conn, "UPDATE FELHASZNALO SET felhasznalonev = :name, jelszo = :passworld, email = :email WHERE id = :id");

                oci_bind_by_name($stid, ':name', $_POST['username']);
                oci_bind_by_name($stid, ':passworld', $hashelt_ujjelszo);
                oci_bind_by_name($stid, ':email', $_POST['email']);
                oci_bind_by_name($stid, ':id', $_GET['id']);

                oci_execute($stid);

                oci_free_statement($stid);

                $_SESSION["felhasznalo"]["felhasznalonev"] = $_POST['username'];
                $_SESSION["felhasznalo"]["email"] = $_POST['email'];

                $success = "Adatok mentve";
            } else {
                $pwd_error = "Nem egyezik meg a régi jelszó az adatbázisban lévő jelszóval. Kérlek azt a jelszót add meg!";
            }
        }
    }
} else {
    $id_error = "Nincs megadva hogy melyik felhasználót szerkesztenéd";
}

?>
<div class="container">
    <h1>Adatok módosítása</h1>

    <?php
    /* TODO: jog kezelés
    if (isset($_SESSION["felhasznalo"])) {
        echo '<div class="alert alert-success" role="alert">
        ' . 'Már be vagy jelentkezve: ' . $_SESSION["felhasznalo"]["felhasznalonev"] . ' , ' . $_SESSION["felhasznalo"]["email"] . '
    </div>';
    }
    */
    ?>
    <?php
    if (isset($id_error)) {
        echo '<div class="alert alert-danger" role="alert">
    ' . $id_error . '
    </div>';
    }
    ?>
    <form action="felhasznalo-szerkeszto-sajat.php?id=<?php echo $_GET["id"]; ?>" method="POST" <?php if (isset($id_error)) echo "hidden" ?>>

        <label for="exampleFormControlInput1" class="form-label">Email cím</label>
        <input type="email" class="form-control <?php
                                                if (isset($_POST['email'])) {
                                                    if (!isset($email_error)) {
                                                        echo '"';
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

        <label for="exampleFormControlInput3" class="form-label is-valid">Felhasználónév</label>
        <input type="text" class="form-control <?php if (isset($_POST['username'])) echo '" ' . 'value="' . $_POST['username'] . '" '; ?>" id="exampleFormControlInput3" name="username" required>


        <label for="inputPassword5" class="form-label">Régi Jelszó</label>
        <input type="password" id="inputPassword5" class="form-control <?php
                                                                        if (isset($_POST['passworld'])) {
                                                                            if (!isset($pwd_error)) {
                                                                                echo '"';
                                                                            } else {
                                                                                echo 'is-invalid"';
                                                                            }
                                                                            echo ' value="' . $_POST['passworld'] . '" ';
                                                                        }
                                                                        ?>" aria-labelledby=" passwordHelpBlock" name="passworld" required>
        <?php
        if (!isset($pwd_error)) {
            // echo '<div class="valid-feedback"> Helyes jelszó </div>';
        } else {
            echo '<div class="invalid-feedback">' . $pwd_error . '</div>';
        }
        ?>

        <label for="inputPassword5" class="form-label">Új Jelszó</label>
        <input type="password" id="inputPassword5" class="form-control <?php if (isset($_POST['newpassworld'])) echo '" ' . 'value="' . $_POST['newpassworld'] . '" '; ?> aria-labelledby=" passwordHelpBlock" name="newpassworld" required>

        <button style="margin: 1rem;" type="submit" name="save" class="btn btn-primary" placeholder="Pista99">Mentés</button>
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