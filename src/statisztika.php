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
        <?php
        include "includes/navbar.php";
        ?>
    </header>

    <main class="container">
        <h1>Statisztikák</h1>
        <ul>
            <li>Legtöbb cikket írt szerző(k):
                <?php
                $array = oci_parse($conn, "select felhasznalonev, email from felhasznalo where felhasznalo.id in (select szerzo_id from 
            (select szerzo_id, count(*) as c from cikk group by szerzo_id)
            where c = (select max(count(*)) from cikk group by szerzo_id))");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    echo $row[0] . " (" . $row[1] . "), ";
                }
                ?>
            </li>
            <li>Legkevesebb cikket írt szerző(k):
                <?php
                $array = oci_parse($conn, "select felhasznalonev, email from felhasznalo where felhasznalo.id in (select szerzo_id from 
            (select szerzo_id, count(*) as c from cikk group by szerzo_id)
            where c = (select min(count(*)) from cikk group by szerzo_id))");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    echo $row[0] . " (" . $row[1] . "), ";
                }
                ?>
            </li>
            <li>Legkevesebbet validált lektor(ok):
                <?php
                $array = oci_parse($conn, "select felhasznalonev, email from felhasznalo where felhasznalo.id in (select szerzo_id from 
            (select szerzo_id, count(*) as c from cikk group by szerzo_id)
            where c = (select min(count(*)) from cikk group by szerzo_id))");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    echo $row[0] . " (" . $row[1] . "), ";
                }
                ?>
            </li>
            <li>Legtöbbet validált lektor(ok):
                <?php
                $array = oci_parse($conn, "select felhasznalonev, email from felhasznalo where felhasznalo.id in (select szerzo_id from 
            (select szerzo_id, count(*) as c from cikk group by szerzo_id)
            where c = (select max(count(*)) from cikk group by szerzo_id))");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    echo $row[0] . " (" . $row[1] . "), ";
                }
                ?>
            </li>
            <li>Legtöbb megjegyzést írt felhasználó(k):
                <?php
                $array = oci_parse($conn, "select felhasznalonev, email from felhasznalo where felhasznalo.id in (
                    select felhasznalo_id from (
                    select megjegyzes.felhasznalo_id,count(*) as c from megjegyzes inner join cikk on cikk.szerzo_id = megjegyzes.felhasznalo_id group by megjegyzes.felhasznalo_id order by count(*)
                    ))");
                oci_execute($array);
                while ($row = oci_fetch_array($array)) {
                    echo $row[0] . " (" . $row[1] . "), ";
                }
                ?>
            </li>
        </ul>

    </main>

    <?php include "includes/footer.php"; ?>


</body>

</html>