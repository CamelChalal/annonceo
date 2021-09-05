        <?php
        include_once('include/init.php');
        // le code PHP du fichier se situera entre init et header

        $trie = '';


        if (isset($_GET['commentaire']) && ($_GET['commentaire'] == "envoyer")) {
            $notification .= "<div class='col-md-6 mx-auto alert alert-success text-center disparition'>
                                Votre commentaire a bien été envoyé !
                            </div>";
        }

        if (isset($_GET['note']) && ($_GET['note'] == "envoyer")) {
            $notification .= "<div class='col-md-6 mx-auto alert alert-success text-center disparition'>
                                Votre note a bien été envoyé !
                            </div>";
        }

        if (isset($_GET['annonce']) && $_GET['annonce'] == "inexistant") {
            $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center disparition'>
                        Annonce inexistante
                    </div>";
        }


        if ($_POST) {

            // print_r($_POST);
            // die;
            if (isset($_POST["categorie-id"])) {
                // echo $_POST["categorie-id"];
                // $categorie = $_POST["categorie"];
                // echo $categorie;
                // die;
                $sql[] = " categorie_id  = " . $_POST["categorie-id"];
            }
            // print_r($sql);
            // die;

            // echo implode(' AND ', $sql);
            // die;


            if (isset($_POST["membre"])) {

                echo $_POST["membre"];
                $membre = $_POST['membre'];

                $sql[] = ' membre_id = ' . $_POST['membre'];
            }

            if (isset($_POST['trie']) && $_POST['trie'] == 'prix_asc') {
                $trie = ' ORDER BY prix ASC';
            }
            if (isset($_POST['trie']) && $_POST['trie'] == 'prix_desc') {
                $trie = ' ORDER BY prix DESC';
            }

            if (isset($_POST['trie']) && $_POST['trie'] == 'date_asc') {
                $trie = ' ORDER BY date_enregistrement DESC';
            }

            if (isset($_POST['trie']) && $_POST['trie'] == 'date_desc') {
                $trie = ' ORDER BY date_enregistrement ASC';
            }
        }

        $pdoStatement = $pdoObject->query("SELECT * FROM annonce WHERE " . implode(' AND ', $sql) . $trie);



        if (isset($_GET['annonce']) && $_GET['annonce'] == "inexistant") {
            $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center disparition'>
                                Annonce inexistante
                            </div>";
        }

        $pdoMembre = $pdoObject->query('SELECT * FROM membre');

        $pdoCat = $pdoObject->query('SELECT * FROM categorie');




        include_once('include/header.php');
        ?>

        <h1 class="text-center m-4">Annonces</h1>


        <?= $notification ?>
        <?= $erreur ?>
        <div class="container">
            <div class="row">
                <div class="left col-sm-4">
                    <form action="" method="post" class="col-md-12">

                        <label for="trie">Trier</label>
                        <select name="trie" id="trie" class="form-control col-sm-12">
                            <option value="" selected disabled>Trier </option>
                            <option value="prix_asc">Du - cher au + cher</option>
                            <option value="prix_desc">Du + cher au - cher</option>
                            <option value="date_asc">Du - ancien au + ancien</option>
                            <option value="date_desc">Du + ancien au - ancien</option>
                        </select>


                        <label for="categorie-id">Catégorie</label><br>
                        <select class="form-control col-md-12 " name="categorie-id" id="categorie-id">
                            <option value="" selected disabled>Sélectionner une catégorie</option>

                            <?php while ($categorie2 = $pdoCat->fetch(PDO::FETCH_ASSOC)) : ?>

                                <option value="<?= $categorie2['id_categorie'] ?>"><?= $categorie2['titres'] ?></option>

                            <?php endwhile; ?>

                        </select><br>

                        <label for="membre">Membre</label><br>
                        <select class="form-control col-md-12 " name="membre" id="membre">
                            <option value="" selected disabled>Sélectionner un membre</option>

                            <?php while ($membre = $pdoMembre->fetch(PDO::FETCH_ASSOC)) : ?>

                                <option value="<?= $membre['id_membre'] ?>"><?= $membre['pseudo'] ?></option>

                            <?php endwhile; ?>
                        </select><br><br>


                        <button type="submit" class="col-md-12 btn btn-dark mt-3">Rechercher</button>
                    </form>
                </div>
                <div class="right col-sm-8">

                    <?php if ($pdoStatement->rowCount() > 0) : ?>



                        <?php while ($arrayAnnonce = $pdoStatement->fetch(PDO::FETCH_ASSOC)) : ?>
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
                        <?php endwhile; ?>


                    <?php else : ?>
                        <h4 class="text-center text-danger">Il n'y a aucun produit</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        include_once('include/footer.php');
