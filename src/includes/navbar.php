<nav class="navbar navbar-expand-lg container">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Tudásadatbázis</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Főoldal</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Cikkek
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="cikk_kategoria.php">Listázás</a></li>

                        <li><a class="dropdown-item <?php if (!isset($_SESSION["felhasznalo"]["rang"]["szerzo"])) echo "disabled";?>" href="cikk_iras.php">Írás</a></li>
                        <li><a class="dropdown-item <?php if (!isset($_SESSION["felhasznalo"]["rang"]["szerzo"])) echo "disabled";?>" href="altalam_irt.php">Általam írt cikkek</a></li>
                        <li><a class="dropdown-item <?php if (!isset($_SESSION["felhasznalo"]["rang"]["lektor"])) echo "disabled";?>" href="ellenorzesre.php">Ellenőrzes</a></li>

                        <!--
                        <?php
                            if(isset($_SESSION["felhasznalo"])){
                                if(isset($_SESSION["felhasznalo"]["rang"]["szerzo"])){
                                    echo '<li><a class="dropdown-item" href="cikk_iras.php">Írás</a></li>';
                                    echo '<li><a class="dropdown-item " href="altalam_irt.php">Általam írt cikkek</a></li>';

                                }
                                
                                if(isset($_SESSION["felhasznalo"]["rang"]["lektor"])){
                                    echo '<li><a class="dropdown-item" href="ellenorzesre.php">Ellenőrzes</a></li>';
                                }
                            }
                        ?>
                        -->
                        
                        <li><a class="dropdown-item disabled" href="#">Létrehozás</a></li>
                        <li><a class="dropdown-item disabled" href="#">Ellenőrzésre váró cikkek</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="felhasznalok.php">Felhasználók</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (isset($_SESSION["felhasznalo"])) {
                            echo $_SESSION["felhasznalo"]["felhasznalonev"] . ' fiókja';
                        } else {
                            echo "Profil";
                        } ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?php if (isset($_SESSION["felhasznalo"])) echo "disabled"; ?>" href="statisztika.php">Statisztikák</a></li>
                        <li><a class="dropdown-item <?php if (isset($_SESSION["felhasznalo"])) echo "disabled"; ?>" href="bejelentkezes.php">Bejelentkezés</a></li>
                        <li><a class="dropdown-item <?php if (isset($_SESSION["felhasznalo"])) echo "disabled"; ?>" href="regisztracio.php">Regisztráció</a></li>
                        <li><a class="dropdown-item <?php if (!isset($_SESSION["felhasznalo"])) echo "disabled"; ?>" href="felhasznalo-szerkeszto.php<?php if (isset($_SESSION["felhasznalo"])) echo "?id=" . $_SESSION["felhasznalo"]["id"]; ?>">Adataim módosítása</a></li>
                        <li><a class="dropdown-item <?php if (!isset($_SESSION["felhasznalo"])) echo "disabled"; ?>" href="kijelentkezes.php">Kijelentkezés</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<hr>