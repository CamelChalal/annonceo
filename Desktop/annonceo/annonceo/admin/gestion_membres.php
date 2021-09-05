<?php
//AFFICHAGE

include_once('../include/init.php');

if (!adminConnected()) {
    header("Location:" . URL . "erreur.php?acces=interdit");
    exit;
}

$pdoStatement = $pdoObject->query("SELECT * FROM membre");

$arrayMembres = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['action']) && ($_GET['action'] == "supprimer")) {

    if (isset($_GET['id_membre'])) {
        $pdoStatement = $pdoObject->prepare('SELECT * FROM membre WHERE id_membre = :id_membre');
        $pdoStatement->bindValue(":id_membre", $_GET['id_membre'], PDO::PARAM_INT);
        $pdoStatement->execute();

        $arrayProduit = $pdoStatement->fetch(PDO::FETCH_ASSOC);



        $pdoStatement = $pdoObject->prepare('DELETE FROM membre WHERE id_membre = :id_membre');
        $pdoStatement->bindValue(":id_membre", $_GET['id_membre'], PDO::PARAM_INT);
        $pdoStatement->execute();


        header('Location:' . URL . "admin/gestion_membres.php?action=afficher&id_membre=supprimer");
    } else {
        header('Location:' . URL . "erreur.php?page=inexistante");
    }
}

include_once('../include/header.php');
?>

<h1 class="text-center m-4">Gestion des membres</h1>

<div class="col-12">
    <?= $notification ?>
</div>

<table class="table table-hover table-striped  text-center mt-5">

    <thead class='thead-dark'>
        <tr>
            <?php for ($i = 0; $i < $pdoStatement->columnCount(); $i++) :


                $colonne = $pdoStatement->getColumnMeta($i);

                // echo "<pre>";
                // print_r($colonne);
                // echo "</pre>";

            ?>
                <?php if ($colonne['name'] != "mdp") : ?>
                    <th><?= ucfirst($colonne['name']) ?></th>

                <?php endif; ?>
            <?php endfor; ?>


            <th>Supprimer</th>


        </tr>
    </thead>

    <tbody>

        <?php foreach ($arrayMembres as $arrayMembre) : ?>

            <tr>
                <?php foreach ($arrayMembre as $keyMembre => $valueMembre) : ?>

                    <?php if ($keyMembre != "mdp") : ?>

                        <th class="align-middle"><?= $valueMembre ?></th>
                    <?php endif; ?>
                <?php endforeach; ?>



                <th class="align-middle">
                    <a href="<?= URL ?>admin/gestion_membres.php?action=supprimer&id_membre=<?= $arrayMembre['id_membre'] ?>" onclick="return confirm('Confirmez-vous la suppression de ce membre ?')">
                        <img src="../images/delete.png" alt="icône de suppression">
                    </a>
                </th>

            </tr>
        <?php endforeach; ?>

    </tbody>


</table>





<?php



include_once('../include/footer.php');
