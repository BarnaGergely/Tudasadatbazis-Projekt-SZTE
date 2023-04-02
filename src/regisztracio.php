<?php
include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');

if (isset($_POST["submit"])) {    // miután az űrlapot elküldték...

    $sql = 'INSERT INTO FELHASZNALO( Felhasznalonev, jelszo, email) ' . 'VALUES( :name, :passworld, :email)';

    $compiled = oci_parse($conn, $sql); //ranezni

    oci_bind_by_name($compiled, ':name', $_POST['username']);
    oci_bind_by_name($compiled, ':passworld', $_POST['passworld']);
    oci_bind_by_name($compiled, ':email', $_POST['email']);

    oci_execute($compiled);
}


?>
<div class="container">
    <form action="regisztracio.php" method="POST">
        <h1>Regisztráció</h1>
        <label for="exampleFormControlInput1" class="form-label">Email cím</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="name@example.com" required>
        <label for="inputPassword5" class="form-label">Jelszó</label>
        <input type="password" id="inputPassword5" class="form-control" aria-labelledby="passwordHelpBlock" name="passworld" required>
        <div id="passwordHelpBlock" class="form-text">
            Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
        </div>
        <label for="exampleFormControlInput3" class="form-label">Felhasználónév</label>
        <input type="text" class="form-control" id="exampleFormControlInput3" name="username" required>
        <button type="submit" name="login" class="btn btn-primary">Regisztráció</button>
    </form>
</div>
<?php
require_once('resources/theme/footer.php');
?>