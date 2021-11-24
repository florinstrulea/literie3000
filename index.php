<?php
include("templates/header.php");
$dsn = "mysql:host=localhost;dbname=literie3000";
$db = new PDO($dsn, "root");
$query = $db->query("SELECT * FROM brands INNER JOIN matelas on brands.idbrands=matelas.id_brands INNER JOIN sizes on matelas.id_sizes=sizes.idsizes");
$datas = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <h1 class="catalog__title title text-center">CATALOGUE</h1>
    <?php
    foreach ($datas as $data) {
    ?>
        <div class="row">
            <div class="image col-md-3"><a href="matelas.php?id=<?= $data["id"] ?>"><img src="img/matelas/<?= $data["image"] ?>" alt=""></a></div>
            <div class="brand col-md-3">
                <p><?= $data["brands"] ?></p>
            </div>
            <div class="matress col-md-3">
                <p>Matelas</p>
                <?= $data["name"] ?>
                <p><?= $data["type"] ?></p>
            </div>
            <div class="prices col-md-3">
                <p><?= $data["prix"] ?> €</p>
                <p><?= ($data["prix_discount"] = "") ? "" : $data["prix_discount"] . "€" ?> </p>
            </div>
        </div>
    <?php
    } ?>
    <div class="buttons">
        <a href="add_matelas.php">Ajouter un matelas</a>
    </div>
</div>

</body>

</html>