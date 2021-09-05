<?php

include_once('../include/init.php');

if (!adminConnected()) {
    header("Location:" . URL . "erreur.php?acces=interdit");
    exit;
}

$pdoStatement = $pdoObject->query("SELECT * FROM commentaire");

$arrayCom = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
// echo "<pre>";
// print_r($arrayCommentaires);
// echo "</pre>";
if (isset($_GET['action']) && ($_GET['action'] == "supprimer")) {

    if (isset($_GET['id_commentaire'])) {
        $pdoStatement = $pdoObject->prepare('SELECT * FROM commentaire WHERE id_commentaire = :id_commentaire');
        $pdoStatement->bindValue(":id_commentaire", $_GET['id_commentaire'], PDO::PARAM_INT);
        $pdoStatement->execute();

        $arrayCom = $pdoStatement->fetch(PDO::FETCH_ASSOC);



        $pdoStatement = $pdoObject->prepare('DELETE FROM commentaire WHERE id_commentaire = :id_commentaire');
        $pdoStatement->bindValue(":id_commentaire", $_GET['id_commentaire'], PDO::PARAM_INT);
        $pdoStatement->execute();


        header('Location:' . URL . "admin/gestion_commentaires.php?action=afficher&id_commentaire=supprimer");
    } else {
        header('Location:' . URL . "erreur.php?page=inexistante");
    }
}

include_once('../include/header.php');

?>

<h1 class="text-center m-4">Gestion des commentaires</h1>

<div class="col-12">
    <?= $notification ?>
</div>

<table class="table table-hover table-striped  text-center mt-5">

    <thead class='thead-dark'>
        <tr>
            <?php for ($i = 0; $i < $pdoStatement->columnCount(); $i++) :


                $colonne = $pdoStatement->getColumnMeta($i);



            ?>



                <th><?= ucfirst($colonne['name']) ?></th>






            <?php endfor; ?>

            <th>Action</th>


        </tr>
    </thead>

    <tbody>

        <?php foreach ($arrayCom as $arrayComment) : ?>

            <tr>
                <?php foreach ($arrayComment as $keyComment => $valueComment) : ?>

                    <th class="align-middle"><?= $valueComment ?></th>

                <?php endforeach; ?>

                <th class="align-middle">

                    <a href="<?= URL ?>admin/gestion_commentaires.php?action=supprimer&id_commentaire=<?= $arrayComment['id_commentaire'] ?>" onclick="return confirm('Confirmez-vous la suppression de ce commentaire ?')">
                        <img src="../images/delete.png" alt="icône de suppression">
                    </a>
                </th>

            </tr>
        <?php endforeach; ?>

    </tbody>


</table>


<?php

include_once('../include/footer.php');
