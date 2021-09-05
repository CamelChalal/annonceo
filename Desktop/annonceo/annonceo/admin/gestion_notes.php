<?php

include_once('../include/init.php');

$trie = '';

if (!adminConnected()) {
    header("Location:" . URL . "erreur.php?acces=interdit");
    exit;
}
$pdoStatement = $pdoObject->query("SELECT * FROM note");

$arrayNotes = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['action']) && ($_GET['action'] == "supprimer")) {

    if (isset($_GET['id_note'])) {
        $pdoStatement = $pdoObject->prepare('SELECT * FROM note WHERE id_note = :id_note');
        $pdoStatement->bindValue(":id_note", $_GET['id_note'], PDO::PARAM_INT);
        $pdoStatement->execute();

        $arrayProduit = $pdoStatement->fetch(PDO::FETCH_ASSOC);



        $pdoStatement = $pdoObject->prepare('DELETE FROM note WHERE id_note = :id_note');
        $pdoStatement->bindValue(":id_note", $_GET['id_note'], PDO::PARAM_INT);
        $pdoStatement->execute();


        header('Location:' . URL . "admin/gestion_notes.php?action=afficher&id_note=supprimer");
    } else {
        header('Location:' . URL . "erreur.php?page=inexistante");
    }
}



include_once('../include/header.php');
?>

<h1 class="text-center m-4">Gestion des notes</h1>

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

                <th><?= ucfirst($colonne['name']) ?></th>


            <?php endfor; ?>


            <th>Supprimer</th>


        </tr>
    </thead>

    <tbody>

        <?php foreach ($arrayNotes as $arrayNote) : ?>

            <tr>
                <?php foreach ($arrayNote as $keyNote => $valueNote) : ?>



                    <th class="align-middle"><?= $valueNote ?></th>

                <?php endforeach; ?>



                <th class="align-middle">
                    <a href="<?= URL ?>admin/gestion_notes.php?action=supprimer&id_note=<?= $arrayNote['id_note'] ?>" onclick="return confirm('Confirmez-vous la suppression de cette note ?')">
                        <img src="../images/delete.png" alt="icône de suppression">
                    </a>
                </th>

            </tr>
        <?php endforeach; ?>

    </tbody>


</table>

<?php

include_once('../include/footer.php');
