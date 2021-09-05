<?php

include_once('include/init.php');

if ($_POST) {

    if (!empty($_POST['recherche'])) {

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        $recherche = $_POST['recherche'];
        $pdoStatement = $pdoObject->query("SELECT * FROM annonce WHERE titre LIKE '%" . $recherche . "%'");


        $arrayAnnonces = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre>";
        // print_r($arrayAnnonces);
        // echo "</pre>";
    } else {

        header('Location:' . URL . 'erreur.php?annonce=inexistante');
    }
}




include_once('include/header.php');
?>

<h1 class="text-center">Recherche</h1>

<?php if ($pdoStatement->rowCount() > 0) : ?>

    <?php foreach ($arrayAnnonces as $arrayAnnonce) : ?>

        <div class="card mb-3 div-card">
            <div class="rounded p-2 clearfix text-center cardShadow col-md-12 col-12 ">

                <h6 class="m-2"><?= $arrayAnnonce['titre'] ?></h6>

                <p class="mt-3"><?= $arrayAnnonce['description_courte'] ?></p>

                <?php if ($arrayAnnonce['photo'] != "") :  ?>
                    <img class='img-fluid rounded' style='width:100px' src="images/imagesUpload/<?= $arrayAnnonce['photo'] ?>" alt="<?= $arrayAnnonce['titre'] ?>" title="<?= $arrayAnnonce['titre'] ?>">
                <?php endif;  ?>

                <h6 class="m-2"><?= $arrayAnnonce['prix'] ?> €</h6>

                <a class="btn btn-dark col-md-3 mt-1 mb-1" href="<?= URL ?>annonces.php?id_annonce=<?= $arrayAnnonce['id_annonce'] ?>">En savoir plus</a>
            </div>
        </div>



    <?php endforeach; ?>

<?php else : ?>

    <h4 class="text-center text-danger mt-5"> Il n'y a aucun produit</h4>
<?php endif; ?>

<?php
include_once('include/footer.php');
