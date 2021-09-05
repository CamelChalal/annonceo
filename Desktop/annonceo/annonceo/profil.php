<?php

include_once('include/init.php');



if (!membreConnected()) {
    header("location:" . URL . "erreur.php?acces=interdit");
    exit;
}


if (isset($_SESSION['notification']) && isset($_SESSION['notification']['mdp']) && $_SESSION['notification']['mdp'] == "modifie") {
    $notification .= "<div class='col-md-6 mx-auto alert alert-success text-center disparition'>
                                        Le mot de passe a bien été changé
                                    </div>";
}


if (isset($_SESSION['notification']) && isset($_SESSION['notification']['profil']) && $_SESSION['notification']['profil'] == "modifie") {
    $notification .= "<div class='col-md-6 mx-auto alert alert-success text-center disparition'>
                                Les informations de votre profil ont bien été modifiées
                            </div>";
}

$pdoStatement = $pdoObject->query('SELECT count(*) FROM annonce WHERE membre_id = ' . $_SESSION["membre"]["id_membre"] . '');

$pdoAnnonce = $pdoObject->query('SELECT * FROM annonce WHERE membre_id = ' . $_SESSION["membre"]["id_membre"] . '');
$arrayAnnonces = $pdoAnnonce->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($arrayAnnonces);
// echo "</pre>";



$pdoNote = $pdoObject->prepare('SELECT * FROM note WHERE membre_id2 = :membre_id2');
$pdoNote->bindValue(":membre_id2", $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
$pdoNote->execute();

$arrayNotes = $pdoNote->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($arrayNotes);
// echo "</pre>";








if (isset($_GET['action']) && ($_GET['action'] == "supprimer")) {

    if (isset($_GET['id_annonce'])) {
        $pdoStatement = $pdoObject->prepare('SELECT * FROM annonce WHERE id_annonce = :id_annonce');
        $pdoStatement->bindValue(":id_annonce", $_GET['id_annonce'], PDO::PARAM_INT);
        $pdoStatement->execute();

        $arrayProduit = $pdoStatement->fetch(PDO::FETCH_ASSOC);



        $pdoStatement = $pdoObject->prepare('DELETE FROM annonce WHERE id_annonce = :id_annonce');
        $pdoStatement->bindValue(":id_annonce", $_GET['id_annonce'], PDO::PARAM_INT);
        $pdoStatement->execute();


        header('Location:' . URL . "profil.php?action=afficher&id_membre=supprimer");

        $notification .= "<div class='col-md-6 mx-auto alert alert-success text-center disparition'>
        Annonce supprimé !
    </div>";
    } else {
        header('Location:' . URL . "erreur.php?page=inexistante");
    }
}







include_once('include/header.php');

?>

<h1 class="text-center m-4">Profile de <?= $_SESSION['membre']['prenom'] ?></h1>

<?= $notification ?>

<div class="m-4">

    <h5 class="list-group-item text-center m-0">Email : <strong> <?= $_SESSION['membre']['email'] ?> </strong></h5>
    <h5 class="list-group-item text-center m-0">Nom : <strong> <?= $_SESSION['membre']['nom'] ?> </strong></h5>
    <h5 class="list-group-item text-center m-0">Prénom : <strong> <?= $_SESSION['membre']['prenom'] ?> </strong></h5>
    <h5 class="list-group-item text-center m-0">Pseudo : <strong> <?= $_SESSION['membre']['pseudo'] ?> </strong></h5>
    <h5 class="list-group-item text-center m-0">Téléphone : <strong> <?= $_SESSION['membre']['telephone'] ?> </strong></h5>






    <div class="row justify-content-around">
        <a class="btn btn-primary col-md-5 col-12 m-1" href="<?= URL ?>modification.php?modification=profil">Modifier le profil</a>
        <a class="btn btn-dark col-md-5 col-12 m-1" href="<?= URL ?>modification.php?modification=mdp">Modifier le mot de passe</a>
    </div>


    <h3 class="text-center m-4">

        Votre nombre d'annonce :
        <div class="badge badge-primary">
            <?= $pdoStatement->fetchColumn() ?>
        </div>


    </h3>
    <div class="right col-sm-8 mx-auto">

        <?php foreach ($arrayAnnonces as $arrayAnnonce) : ?>

            <div class="card mb-3 div-card">
                <div class="rounded p-2 clearfix text-center cardShadow col-md-12 col-12 ">

                    <h6 class="m-2"><?= $arrayAnnonce['titre'] ?></h6>

                    <p class="mt-3"><?= $arrayAnnonce['description_courte'] ?></p>

                    <?php if ($arrayAnnonce['photo'] != "") :  ?>
                        <img class='img-fluid rounded' style='width:100px' src="images/imagesUpload/<?= $arrayAnnonce['photo'] ?>" alt="<?= $arrayAnnonce['titre'] ?>" title="<?= $arrayAnnonce['titre'] ?>">
                    <?php endif;  ?>

                    <h6 class="m-2"><?= $arrayAnnonce['prix'] ?> €</h6>


                    <a href="<?= URL ?>profil.php?action=supprimer&id_annonce=<?= $arrayAnnonce['id_annonce'] ?>" onclick="return confirm('Confirmez-vous la suppression de cette annonce ?')">
                        <img src="images/delete.png" alt="icône de suppression">
                    </a>

                </div>
            </div>



        <?php endforeach; ?>

        <div class="card-body">
            <h6 class="card-title">Pour voir les commentaires</h6>

        </div>
        <div class="card-footer">
            <p>
                <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Cliquer ici</a>
            </p>

        </div>
        <div class="collapse multi-collapse" id="multiCollapseExample2">
            <div class="card card-body">


                <?php foreach ($arrayAnnonces as $arrayAnnonce) : ?>

                    <?php

                    $pdoCommentaire = $pdoObject->prepare('SELECT commentaire, annonce_id FROM commentaire WHERE annonce_id = :annonce_id');
                    $pdoCommentaire->bindValue(":annonce_id", $arrayAnnonce['id_annonce'], PDO::PARAM_INT);
                    $pdoCommentaire->execute();

                    $arrayCommentaires = $pdoCommentaire->fetch(PDO::FETCH_ASSOC);

                    // echo "<pre>";
                    // print_r($arrayCommentaires);
                    // echo "</pre>";

                    ?>


                    <?php if (!empty($arrayCommentaires)) : ?>
                        <?php if ($arrayAnnonce['id_annonce'] == ($arrayCommentaires['annonce_id'])) : ?>
                            <div class="col text-center">
                                <?= $arrayCommentaires['commentaire'] . "<hr>" ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>

            </div>
        </div>
        <div class="card-body">
            <h6 class="card-title">Pour voir les notes</h6>

        </div>
        <div class="card-footer">
            <p>
                <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Cliquer ici</a>
            </p>

        </div>
        <div class="collapse multi-collapse" id="multiCollapseExample3">
            <div class="card card-body">



                <?php foreach ($arrayNotes as $key => $value) : ?>


                    <?php if (!empty(['note'])) : ?>

                        <div class="col text-center">
                            <?= $value['note'] . "<hr>"; ?>
                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        </div>


    </div>

    <?php

    include_once('include/footer.php');
