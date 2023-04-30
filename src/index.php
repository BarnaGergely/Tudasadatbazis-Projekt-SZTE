<?php include "resources/functions/config.php"; ?>

<!DOCTYPE html>
<html lang="hu" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tudásadatbázis</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="resources/styles/theme.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include "includes/navbar.php"; ?>
    </header>

    <main>
        
        <div class="container">  
        <h1>Üdvözöllek a Tudásadatbázisban!</h1>
            <div>Ezt a webes alkalmazást azért hoztuk létre, hogy bárki ingyenesen elérhessen rövid ismeretterjesztő cikkeket.
            Ha egy témakörön belül keresel valamit, kattints a cikkekre majd a listázásra.
            Itt témakörökre bontva megtekintheted a már publikált cikkeket.</div></br>
            <div>Amennyiben komolyabban érdekel kicsiny kis oldalunk, a profil -> regisztráció menüpontban regisztrálhatsz, ezáltal új funkciókat érhetsz el.
            Regisztráció után a profil -> bejelentkezés fülnél be tudsz jelentkezni.
            Ezután a cikkek alá megjegyzéseket is írhatsz, melyek a felhasználó neveddel megjelennek a cikk alatt.</div></br>
            <div>Amennyiben cikkeket szeretnél írni, írj egy emailt az admin@admin.hu email címre egy rövid bemutatkozó szöveggel és, hogy milyen témakörökben szeretnél tartalmat írni.
            Kapni fogsz egy tájékoztatót, a szerzőkre, lektorokra vonatkozó kötelezettségekről, szabályokról majd kérésedet 24 órán belül elbíráljuk, majd visszajelzést küldünk. Ha elfogadtuk, következő bejelentkezésed alkalmával már szerző jogokkal is rendelkezel.
            Szerzőként írhatsz cikkeket. A cikknek adj egy címet, sorold be egy már létező kategóriába, vagy hozz létre új kategóriát.
            Kulcsszavakat is megadhatsz, így megkönnyítve, hogy mások megtalálják a cikket.
            Beküldés után a cikkedet egy lektornak jóvá kell hagyni. A cikkeidet az általam írt cikkek menüpont alatt találhatod meg.
            Itt még publikálás előtt módosíthatsz rajta vagy akár törölheted is.
            Miután egy lektor elfogadta a cikkedet, az megjelenik mindenki számára. Később is módosíthatod, vagy törölheted.</div></br>
            <div>Lektor rangot is az admin@admin.hu email címen tudsz igényelni. Ennek feltételei a következők:
            <ul>
                <li>Legalább 1 hónapja regisztrált felhasználónak kell lenned.</li>
                <li>Legalább 5 publikált cikkel kell rendelkezned.</li>
                <li>Vállalnod kell, hogy havonta legalább 5 cikket ellenőrzöl.</li>
            </ul>    
            Miután megkaptad a lektor rangot, elérheted az ellenőrzés menüpontot. Itt találod a publikálatlan cikkeket, amelyeket publikálni, módosítani vagy törölni tudsz.
            Lektorként a publikált cikkeket is módosíthatod vagy törölheted.</div></br>
            <div> A legmagasabb rang, az admin. Egy admin megtekintheti a felhasználókat, rangokat oszthat ki, vagy vehet el, valamint felhasználókat törölhet.
            Jelenleg nincs nyitott pozíció admin rangra. Amennyiben lesz, a főoldalon hirdetünk meg felvételt ezért érdemes rendszeresen figyelni.</div>
        </div></br>
        <div class="container">
            <h2>Elérhetőségeink</h2>
            <ul>
                <li>Email: admin@admin.hu</li>
                <li>Tel: 06201234567 (hétköznap 8:00 és 15:00 között)</li>
            </ul>
        </div>
    </main>

    <?php include "includes/footer.php"; ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

</body>

</html>