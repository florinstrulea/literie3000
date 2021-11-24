<?php
include("templates/header.php");
$dsn = "mysql:host=localhost;dbname=literie3000";
$db = new PDO($dsn, "root");
$query = $db->query("SELECT * FROM brands INNER JOIN matelas on brands.idbrands=matelas.id_brands INNER JOIN sizes on matelas.id_sizes=sizes.idsizes");
$datas = $query->fetchAll(PDO::FETCH_ASSOC);
