<?php
include("templates/header.php");
$data = array(
    "name" => "",
    "brand" => "",
    "type" => "",
    "prix" => "",
    "prix_discount" => "",
    //"image" => "",

);
$errors = [];
$types = array(
    "1" => "90 x190",
    "2" => "140 x 190",
    "3" => "160 x 190",
    "4" => "180 x 190",
    "5" => "200 x 190"
);
$brands = array(
    "1" => "Epeda",
    "2" => "Dreamway",
    "3" => "Bultex",
    "4" => "DorsoLine",
    "5" => "MemoryLine"
);



if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $data[$key] = trim(strip_tags($value));
    }
    var_dump($data);
    if (empty($data["name"])) {
        $errors["name"] = "Le nom du matelas est obligatoire";
    }
    if (empty($data["brand"])) {
        $errors["brand"] = "La marque du matelas est obligatoire";
    }
    if (empty($data["type"])) {
        $errors["type"] = "Le type du matelas est obligatoire";
    }
    if (empty($data["prix"])) {
        $errors["prix"] = "Le prix du matelas est obligatoire";
    }
    // if (empty($data["image"])) {
    //     $errors["image"] = "L'image du matelas est obligatoire";
    // }
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        //verifier qu'un fichier a bien ete uploadé via le champ file et que l'upload s'est bien passée

        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $fileType = $_FILES["image"]["type"];
        $fileTmpPath = $_FILES["image"]["tmp_name"];

        $fileNameArray = explode(".", $fileName);
        //La fonction end() est trés pratique pour recuperer le dernier élément  d'un tableau 
        $fileExtension = end($fileNameArray);
        //On génére un nouveau nom de fichier pour eleminer et ne pa se preocouper des espaces, des caracteres accentuées et aussi des doublons des images etc...
        //L'ajout de time permet  d'etre sur d'avoir un hash unique autrement dit deux personnes peuvent uploader une image portant strictement le meme nom et le hash géneré era different
        $newFileName = md5(time() . $fileName) . "." . $fileExtension;
        $fileDestPath = "./img/matelas/{$newFileName}";

        //tableau contenant les types des fichiers acceptées
        $allowedTypes = array("image/jpeg", "image/png", "image/webp");
        if (in_array($fileType, $allowedTypes)) {
            //le type de fichier est valide donc on peut ajouter le fichier  à notre serveur 
            //Deplacer le fichier du dossier temporaraire vers le dossier data 
            move_uploaded_file($fileTmpPath, $fileDestPath);
        } else {
            //Le type de fichier est incorrect
            $errors["image"] = "Le type de fichier est incorrect (.jpg, .png ou .webp requis)";
        }

        if (empty($errors)) {
            // Connexion à la base
            $dsn = "mysql:host=localhost;dbname=literie3000";
            $db = new PDO($dsn, "root");

            foreach ($types as $key => $type) {

                if ($data["type"] == $type) {
                    $data["type"] = $key;
                }
            }
            foreach ($brands as $key => $brand) {
                if ($data["brand"] == $brand) {
                    $data["brand"] = $key;
                }
            }
            var_dump($data["brand"]);

            // Requête d'insertion en BDD de la recette
            $query = $db->prepare("INSERT INTO matelas (name, id_brands, id_sizes, prix, prix_discount, image) 
            VALUES (:name, :id_brands, :id_sizes, :prix, :prix_discount, :image)");
            $query->bindParam(":name", $data["name"]);
            $query->bindParam(":id_brands", $data["brand"]);
            $query->bindParam(":id_sizes", $data["type"]);
            $query->bindParam(":prix", $data["prix"]);
            $query->bindParam(":prix_discount", $data["prix_discount"]);
            $query->bindParam(":image", $newFileName);



            if ($query->execute()) {
                // La requête a été exécutée donc on redirige l'utilisateur vers la page d'accueil
                header("Location: ./index.php");
            } else echo "il y a eu un problemé";
        }
    }
}

?>
<h1 class="title text-center">Ajouter une matelas</h1>
<div class="container d-flex justify-content-center">


    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="inputName">Nom du matelas :</label>
            <input type="text" id="inputName" name="name" value="<?= $data["name"] ?>">
            <?php
            if (isset($errors["name"])) {
            ?>
                <span class="info-error"><?= $errors["name"] ?></span>
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="inputBrand">Marque du matelas :</label>
            <select name="brand" id="inputBrand">
                <option value="">Selectionez la marque du matelas</option>
                <option value="Epeda">Epeda</option>
                <option value="Dreamway">Dreamway</option>
                <option value="Bultex">Bultex</option>
                <option value="DorsoLine">DorsoLine</option>
                <option value="Memory Line">MemoryLine</option>
            </select>


            <?php
            if (isset($errors["brand"])) {
            ?>
                <span class="info-error"><?= $errors["brand"] ?></span>
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="inputType">Type du matelas :</label>
            <select name="type" id="inputType">
                <option value="">Selectionez la taille du matelas</option>
                <option value="90 x 190">90 x 190</option>
                <option value="140 x 190">140 x 190</option>
                <option value="160 x 190">160 x 190</option>
                <option value="180 x 200">180 x 200</option>
                <option value="200 x 200">200 x 200</option>
            </select>

            <?php
            if (isset($errors["type"])) {
            ?>
                <span class="info-error"><?= $errors["type"] ?></span>
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="inputPrix">Prix du matelas :</label>
            <input type="number" id="inputPrix" name="prix" value="<?= $data["prix"] ?>" min="100" max="9999">
            <?php
            if (isset($errors["prix"])) {
            ?>
                <span class="info-error"><?= $errors["prix"] ?></span>
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="inputPrix_discount">Prix remisé :</label>
            <input type="number" id="inputPrix_discount" name="prix_discount" value="<?= $data["prix_discount"] ?>" min="100" max="9999">
            <?php
            if (isset($errors["prix_discount"])) {
            ?>
                <span class="info-error"><?= $errors["prix_discount"] ?></span>
            <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="inputImage">Ajouter une image :</label>
            <input type="file" id="inputImage" name="image">
            <?php
            if (isset($errors["image"])) {
            ?>
                <span class="info-error"><?= $errors["image"] ?></span>
            <?php
            }
            ?>
        </div>
        <input type="submit" value="Envoyer">

    </form>

</div>