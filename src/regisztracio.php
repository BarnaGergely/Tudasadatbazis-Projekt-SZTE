<?php
include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');

if (isset($_POST["login"])) {    // miután az űrlapot elküldték...
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") {
        // ha a kötelezően kitöltendő űrlapmezők valamelyike üres, akkor hibaüzenetet jelenítünk meg
        $uzenet = "<strong>Hiba:</strong> Adj meg minden adatot!";
    } else {
        // ha megfelelően kitöltötték az űrlapot, lementjük az űrlapadatokat egy-egy változóba
        $felhasznalonev = $_POST["felhasznalonev"];
        $jelszo = $_POST["jelszo"];

        // bejelentkezés sikerességének ellenőrzése
        $uzenet = "Sikertelen belépés! A belépési adatok nem megfelelők!";  // alapból azt feltételezzük, hogy a bejelentkezés sikertelen

        foreach ($fiokok as $fiok) {              // végigmegyünk a regisztrált felhasználókon
            // a bejelentkezés pontosan akkor sikeres, ha az űrlapon megadott felhasználónév-jelszó páros megegyezik egy regisztrált felhasználó belépési adataival
            // a jelszavakat hash alapján, a password_verify() függvénnyel hasonlítjuk össze
            if ($fiok["felhasznalonev"] === $felhasznalonev && password_verify($jelszo, $fiok["jelszo"])) {
                $uzenet = "Sikeres belépés!";        // ekkor átírjuk a megjelenítendő üzenet szövegét
                break;                               // mivel találtunk illeszkedést, ezért a többi felhasználót nem kell megvizsgálnunk, kilépünk a ciklusból 
            }
        }
    }
}

?>
<div class="container">
    <form action="regisztracio.php" method="POST">
        <h1>Regisztráció</h1>
        <label for="exampleFormControlInput1" class="form-label">Email cím</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" name="email" placeholder="name@example.com">
        <label for="inputPassword5" class="form-label">Jelszó</label>
        <input type="password" id="inputPassword5" class="form-control" aria-labelledby="passwordHelpBlock" name="passworld">
        <div id="passwordHelpBlock" class="form-text">
            Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
        </div>
        <label for="exampleFormControlInput3" class="form-label">Felhasználónév</label>
        <input type="text" class="form-control" id="exampleFormControlInput3" name="username">
        <button type="submit" name="login" class="btn btn-primary">Regisztráció</button>
    </form>
</div>
<?php
require_once('resources/theme/footer.php');
?>