<?php
include "resources/functions/config.php";
if (!$_SESSION["felhasznalo"]["rang"]["szerzo"]) {
    header("Location: index.php");
}

include_once 'resources/functions/config.php';
require_once('resources/theme/header.php');

$cim = "";
$kat = "";
$content = "";

if (isset($_GET["id"])) {
    $stmt = oci_parse($conn, "SELECT * from cikk where id = " . $_GET["id"]);
    oci_execute($stmt);

    $row = oci_fetch_array($stmt);
    $cim = $row["CIM"];
    $content = $row["TARTALOM"]->load();

    $stmt = oci_parse($conn, "SELECT * from kategoria where cikk_id = " . $_GET["id"]);
    oci_execute($stmt);
    $row = oci_fetch_array($stmt);
    $kat = $row[1];
}

if(isset($_POST["cim"])){
    $cimcount = 0;
    $stmt = oci_parse($conn, "BEGIN :result := CIKKLETEZIKE(:cim); END;");
    oci_bind_by_name($stmt, ':cim', $_POST["cim"]);
    oci_bind_by_name($stmt, ':result', $cimcount, PDO::PARAM_INT);
    oci_execute($stmt);

    if ($cimcount > 0) {
        $uzenet = '<div class="alert alert-success" role="alert">Már van ilyen nevű cikk az adatbázisban.</div>';
    } else {
        $uzenet = '<div class="alert alert-danger" role="alert">Még nincs ilyen nevű cikk a rendszerben.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tudásbázis</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">
            <?php
            if (isset($_GET["id"])) {
                echo "Módosítsd a cikket!";
            } else {
                echo "Írj saját cikket!";
            }
            ?>
        </h1>

        <form action="cikk_beszuras.php" method="post">
            <p>
                <label for="cikkcim">Cikk cime: </label>
                <input type="text" name="cim" id="cikkcim" value="<?php echo $cim; ?>">
            </p>

            <p>
                <label for="kat">Cikk kategóriája: </label>
                <input type="text" name="kat" id="kat" value="<?php echo $kat; ?>">
            </p>
            <textarea name="content" class="form-control" rows="7"><?php echo $content; ?></textarea>


            <?php
            if (isset($_GET["id"])) {
                echo '<input type="hidden" name="id" value="' . $_GET["id"] . '"/>';
            }
            ?>

            <label for="k">Adj hozzá keresőszavakat vesszővel elválasztva elválasztva</label>
            <input type="text" name="keresoszavak" id="k">
            <br>

            <input class="btn btn-primary mt-3" type="submit" value="Küldés">

        </form>
        <hr>
        <form action="cikk_iras.php" method="post">
            <fieldset>
            <legend>Létezik e ilyen című cikk?</legend>
                Cím: <input type="text" name="cim"><br>
                <input class="btn btn-primary mt-3" type="submit" value="Ellenőriz">
            </fieldset>
        </form>
        <?php
            if (isset($uzenet)){
                echo $uzenet;
            }
        ?>

    </div>
    <?php include "includes/footer.php"; ?>

</body>

</html>