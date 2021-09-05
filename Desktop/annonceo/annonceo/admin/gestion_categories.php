    <?php

    include_once('../include/init.php');

    if (!adminConnected()) {
        header("Location:" . URL . "erreur.php?acces=interdit");
        exit;
    }

    $pdoStatement = $pdoObject->query("SELECT * FROM categorie");

    $arrayCategories = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);



    if (isset($_GET['action']) && ($_GET['action'] == "supprimer")) {

        if (isset($_GET['id_categorie'])) {
            $pdoStatement = $pdoObject->prepare('SELECT * FROM categorie WHERE id_categorie = :id_categorie');
            $pdoStatement->bindValue(":id_categorie", $_GET['id_categorie'], PDO::PARAM_INT);
            $pdoStatement->execute();

            $arrayProduit = $pdoStatement->fetch(PDO::FETCH_ASSOC);



            $pdoStatement = $pdoObject->prepare('DELETE FROM categorie WHERE id_categorie = :id_categorie');
            $pdoStatement->bindValue(":id_categorie", $_GET['id_categorie'], PDO::PARAM_INT);
            $pdoStatement->execute();


            header('Location:' . URL . "admin/gestion_categories.php?action=afficher&id_categorie=supprimer");
        } else {
            header('Location:' . URL . "erreur.php?page=inexistante");
        }
    }

    if ($_POST) {

        if (!empty($_POST['titres']) && !empty($_POST['motcles'])) {

            $pdoStatement = $pdoObject->prepare('INSERT INTO categorie (titres, motcles) VALUES (:titre, :motcles)');

            $pdoStatement->bindValue(":titre",  $_POST['titres'], PDO::PARAM_STR);
            $pdoStatement->bindValue(":motcles",  $_POST['motcles'], PDO::PARAM_STR);

            $pdoStatement->execute();
        } else {

            $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center disparition'>
                                   Veuillez remplir les champs
                                </div>";
        }
    }

    include_once('../include/header.php');
    ?>

    <h1 class="text-center m-4">Gestion des catégories</h1>


    <div class="col-12">
        <?= $notification ?>
        <?= $erreur ?>
    </div>

    <table class="table table-hover table-striped  text-center mt-5">

        <thead class='thead-dark'>
            <tr>
                <?php for ($i = 0; $i < $pdoStatement->columnCount(); $i++) :


                    $colonne = $pdoStatement->getColumnMeta($i);




                ?>


                    <?php if ($colonne['name'] == "motcles") : ?>
                        <th>Mots cles</th>
                    <?php else : ?>
                        <th><?= ucfirst($colonne['name']) ?></th>
                    <?php endif; ?>



                <?php endfor; ?>

                <th>Action</th>


            </tr>
        </thead>

        <tbody>

            <?php foreach ($arrayCategories as $arrayCategorie) : ?>

                <tr>
                    <?php foreach ($arrayCategorie as $keyCategorie => $valueCategorie) : ?>



                        <?php if ($keyCategorie == "photo") : ?>

                            <?php if ($valueCategorie != "") : ?>

                                <th class="align-middle"><img style='width:80px' src="../images/imagesUpload/<?= $valueCategorie ?>" alt="<?= $arrayCategorie['titre'] ?>" title="<?= $arrayCategorie['titre'] ?>"></th>


                            <?php endif;  ?>



                        <?php else : ?>
                            <th class="align-middle"><?= $valueCategorie ?></th>
                        <?php endif; ?>



                    <?php endforeach; ?>

                    <th class="align-middle">

                        <a href="<?= URL ?>admin/gestion_categories.php?action=supprimer&id_categorie=<?= $arrayCategorie['id_categorie'] ?>" onclick="return confirm('Confirmez-vous la suppression de cette annonce ?')">
                            <img src="../images/delete.png" alt="icône de suppression">
                        </a>
                    </th>



                </tr>
            <?php endforeach; ?>

        </tbody>


    </table>
    <form method="post">

        <div class="row col-6">
            <div class="right col-12 ">
                <div class="form-group m-3">
                    <label for="titres">Titre</label>
                    <input type="text" class="form-control" id="titres" name="titres" placeholder="Ajouter un titre">
                </div>



                <div class="form-group m-3">
                    <label for="motcles">Description Courte</label>
                    <input type="text" class="form-control" id='motcles' name="motcles" placeholder="description">
                </div>

            </div>

            <button type="submit" class="col-4 m-5 btn btn-dark mt-2 text-center">Envoyer</button>
        </div>
    </form>


    <?php

    include_once('../include/footer.php');
