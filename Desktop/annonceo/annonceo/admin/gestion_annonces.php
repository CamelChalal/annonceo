    <?php
    include_once('../include/init.php');
    // le code PHP du fichier se situera entre init et header


    if (!adminConnected()) {
        header("location:" . URL . "erreur.php?acces=interdit");
        exit;
    }



    $pdoStatement = $pdoObject->query("SELECT * FROM annonce");

    $arrayAnnonces = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['action']) && ($_GET['action'] == "supprimer")) {

        if (isset($_GET['id_annonce'])) {
            $pdoStatement = $pdoObject->prepare('SELECT * FROM annonce WHERE id_annonce = :id_annonce');
            $pdoStatement->bindValue(":id_annonce", $_GET['id_annonce'], PDO::PARAM_INT);
            $pdoStatement->execute();

            $arrayProduit = $pdoStatement->fetch(PDO::FETCH_ASSOC);



            $pdoStatement = $pdoObject->prepare('DELETE FROM annonce WHERE id_annonce = :id_annonce');
            $pdoStatement->bindValue(":id_annonce", $_GET['id_annonce'], PDO::PARAM_INT);
            $pdoStatement->execute();


            header('Location:' . URL . "admin/gestion_annonces.php?action=afficher&id_membre=supprimer");
        } else {
            header('Location:' . URL . "erreur.php?page=inexistante");
        }
    }





    include_once('../include/header.php');
    ?>

    <h1 class="text-center m-4">Gestion des annonces</h1>



    <div class="g-0">

        <table class="table table-hover table-striped  text-center mt-5">

            <thead class='thead-dark'>
                <tr>
                    <?php for ($i = 0; $i < $pdoStatement->columnCount(); $i++) :


                        $colonne = $pdoStatement->getColumnMeta($i);




                    ?>

                        <?php if ($colonne['name'] != "photo_id" && $colonne['name'] != "id_photo") : ?>
                            <?php if ($colonne['name'] == "membre_id") : ?>
                                <th scope="col">Membre</th>
                            <?php elseif ($colonne['name'] == "id_annonce") : ?>
                                <th scope="col">ID annonce</th>
                            <?php elseif ($colonne['name'] == "categorie_id") : ?>
                                <th scope="col">Catégorie</th>
                            <?php elseif ($colonne['name'] == "description_courte") : ?>
                                <th scope="col">description courte</th>
                            <?php elseif ($colonne['name'] == "description_longue") : ?>
                                <th scope="col">description longue</th>
                            <?php elseif ($colonne['name'] == "date_enregistrement") : ?>
                                <th scope="col">date d'enregistrement</th>
                            <?php else : ?>
                                <th scope="col"><?= ucfirst($colonne['name']) ?></th>
                            <?php endif; ?>
                        <?php endif; ?>


                    <?php endfor; ?>

                    <th>Action</th>


                </tr>
            </thead>

            <tbody>

                <?php foreach ($arrayAnnonces as $arrayAnnonce) : ?>

                    <tr>
                        <?php foreach ($arrayAnnonce as $keyAnnonce => $valueAnnonce) : ?>

                            <?php if ($keyAnnonce != "photo_id" && $keyAnnonce != "id_photo") : ?>

                                <?php if ($keyAnnonce == "photo") : ?>

                                    <?php if ($valueAnnonce != "") : ?>

                                        <th class="align-middle" scope="row"><img style='width:80px' src="../images/imagesUpload/<?= $valueAnnonce ?>" alt="<?= $arrayAnnonce['titre'] ?>" title="<?= $arrayAnnonce['titre'] ?>"></th>

                                    <?php else :  ?>

                                        <th class="align-middle" scope="row"><img class='img-fluid rounded' style='width:80px' src="../images/imageDefault.jpg" alt="" title=""></th>
                                    <?php endif;  ?>



                                <?php else : ?>
                                    <th class="align-middle" scope="row"><?= $valueAnnonce ?></th>
                                <?php endif; ?>

                            <?php endif; ?>

                        <?php endforeach; ?>

                        <th class="align-middle" scope="row">

                            <a href="<?= URL ?>../annonceo/annonces.php?id_annonce=<?= $arrayAnnonce['id_annonce'] ?>">
                                <img src="../images/loupe.png" alt="icône loupe">
                            </a>
                            <a href="<?= URL ?>admin/gestion_annonces.php?action=supprimer&id_annonce=<?= $arrayAnnonce['id_annonce'] ?>" onclick="return confirm('Confirmez-vous la suppression de cette annonce ?')">
                                <img src="../images/delete.png" alt="icône de suppression">
                            </a>
                        </th>


                    </tr>
                <?php endforeach; ?>

            </tbody>


        </table>

    </div>

    <?php
    include_once('../include/footer.php');
