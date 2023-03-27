<?php
include_once './../resources/functions/config.php';
require_once('../resources/theme/header.php');
?>
<div class="container">
    <form action="bejelentkezes.php" method="POST">
        <h1>Bejelentkezés</h1>
        <label for="exampleFormControlInput1" class="form-label" name="email">Email cím</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="name@example.com">
        <label for="inputPassword5" class="form-label" name="passworld">Jelszó</label>
        <input type="password" id="inputPassword5" class="form-control" aria-labelledby="passwordHelpBlock">
        <button type="submit" name="login" class="btn btn-primary">Bejelentkezés</button>
    </form>
</div>

<?php
require_once('../resources/theme/footer.php');
?>