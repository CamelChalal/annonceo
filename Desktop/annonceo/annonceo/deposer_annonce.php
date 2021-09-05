        <?php

        include_once('./include/init.php');


        if (!membreConnected()) {
            header("Location:" . URL . "erreur.php?acces=interdit");
            exit;
        }


        $pdoCat = $pdoObject->query('SELECT * FROM categorie');



        $membreId = $_SESSION['membre']['id_membre'];


        if ($_POST) {
            // echo "<pre>";
            // print_r($_POST);
            // echo "</pre>";

            $nomPhoto = "";

            if (!empty($_POST['titre']) && !empty($_POST['prix']) && !empty($_POST['description_courte'])) {

                if (!empty($_POST['categorie_id']) && !empty($_POST['ville']) && !empty($_POST['pays'])) {

                    if (!empty($_FILES['images']['name'][0]) != "") {
                        // echo "<pre>"; print_r($_FILES); echo "</pre>";
                        if (!empty($_FILES['images']['name'][5]) == "") {

                            $arrayNomImages = [];

                            for ($i = 0; $i < count($_FILES['images']['name']); $i++) {


                                $nomPhoto = date('YmdHis') . "-" . rand(1, 1000) . "-" . $_FILES['images']['name'][$i];

                                $dossierPhoto = RACINE_IMAGES . $nomPhoto;

                                copy($_FILES['images']['tmp_name'][$i], $dossierPhoto);



                                array_push($arrayNomImages, $nomPhoto);
                            }

                            // echo "<pre>";
                            // print_r($arrayNomImages);
                            // echo "</pre>";
                            // die;
                            // echo "<pre>";
                            // print_r($nomPhoto);
                            // echo "</pre>";


                            $pdoStatement = $pdoObject->prepare('INSERT INTO photo (photo1, photo2, photo3, photo4, photo5) VALUES ( :photo1, :photo2, :photo3, :photo4, :photo5)');

                            if (isset($arrayNomImages[0])) {
                                $pdoStatement->bindValue(":photo1", $arrayNomImages[0], PDO::PARAM_STR);
                            } else {
                                ltrim($pdoStatement->bindValue(":photo1", "", PDO::PARAM_STR));
                            }
                            if (isset($arrayNomImages[1])) {
                                $pdoStatement->bindValue(":photo2", $arrayNomImages[1], PDO::PARAM_STR);
                            } else {
                                ltrim($pdoStatement->bindValue(":photo2", "", PDO::PARAM_STR));
                            }
                            if (isset($arrayNomImages[2])) {
                                $pdoStatement->bindValue(":photo3", $arrayNomImages[2], PDO::PARAM_STR);
                            } else {
                                ltrim($pdoStatement->bindValue(":photo3", "", PDO::PARAM_STR));
                            }
                            if (isset($arrayNomImages[3])) {
                                $pdoStatement->bindValue(":photo4", $arrayNomImages[3], PDO::PARAM_STR);
                            } else {
                                ltrim($pdoStatement->bindValue(":photo4", "", PDO::PARAM_STR));
                            }
                            if (isset($arrayNomImages[4])) {
                                $pdoStatement->bindValue(":photo5", $arrayNomImages[4], PDO::PARAM_STR);
                            } else {
                                ltrim($pdoStatement->bindValue(":photo5", "", PDO::PARAM_STR));
                            }

                            // $pdoStatement->bindValue(":photo2", $arrayNomImages[1], PDO::PARAM_STR);
                            // $pdoStatement->bindValue(":photo3", $arrayNomImages[2], PDO::PARAM_STR);
                            // $pdoStatement->bindValue(":photo4", $arrayNomImages[3], PDO::PARAM_STR);
                            // $pdoStatement->bindValue(":photo5", $arrayNomImages[4], PDO::PARAM_STR);


                            $pdoStatement->execute();
                            $id_photo = $pdoObject->lastInsertId();


                            $pdoStatement = $pdoObject->prepare('INSERT INTO annonce (titre, prix, description_courte, description_longue, pays, adresse, cp, ville,  categorie_id, membre_id, photo, photo_id, date_enregistrement) VALUES (:titre, :prix, :description_courte, :description_longue, :pays, :adresse, :cp, :ville, :categorie_id, :membre_id, :photo, :photo_id, :date_enregistrement) ');

                            foreach ($_POST as $key => $value) {

                                if (gettype($value) == "string") {
                                    $type = PDO::PARAM_STR;
                                } else {
                                    $type = PDO::PARAM_INT;
                                }


                                $pdoStatement->bindValue(":$key", $value, $type);
                            }


                            $pdoStatement->bindValue(":membre_id",  $membreId, PDO::PARAM_INT);
                            $pdoStatement->bindValue(":photo", $nomPhoto, PDO::PARAM_STR);
                            $pdoStatement->bindValue(":photo_id", $id_photo, PDO::PARAM_INT);
                            $pdoStatement->bindValue(":date_enregistrement", date('Y-m-d H:i:s'), PDO::PARAM_STR);



                            $pdoStatement->execute();
                        } else {
                            $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                                    5 photo max
                                    </div>";
                        }
                    } else {
                        $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                                Veuillez inserer une photo!
                                    </div>";
                    }
                } else {
                    $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                        Veuillez remplir les champs !
                                    </div>";
                }
            } else {
                $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                                        Veuillez remplir les champs !
                            </div>";
            }
        }











        include_once('include/header.php');
        ?>


        <h1 class="text-center m-4">Déposer une annonce</h1>

        <?= $erreur ?>


        <form method="post" class="col-md-6" enctype="multipart/form-data">
            <!-- enctype="multipart/form-data" permet de récupérer des fichiers (type file) -->

            <div class="form-group m-3">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id='titre' name="titre" placeholder="Titre de l'annonce">
            </div>

            <div class="form-group m-3">
                <label for="description_courte">Description courte</label>
                <textarea type="text" class="form-control" id='description_courte' name="description_courte" placeholder="Descritpion courte de votre annonce"></textarea>
            </div>

            <div class="form-group m-3">
                <label for="description_longue">Description longue</label>
                <textarea type="text" class="form-control" id='description_longue' name="description_longue" placeholder="Descritpion longue de votre annonce"></textarea>
            </div>

            <div class="form-group m-3">
                <label for="prix">Prix</label>
                <input type="number" class="form-control" id='prix' name="prix" placeholder="Saisir un prix">
            </div>


            <div class="form-group m-3">
                <label for="categorie_id">Catégorie</label>
                <select class="form-control" name="categorie_id" id="categorie_id">
                    <option value="" selected disabled>Sélectionner une catégorie</option>

                    <?php while ($categorie = $pdoCat->fetch(PDO::FETCH_ASSOC)) : ?>

                        <option value="<?= $categorie['id_categorie'] ?>"><?= $categorie['titre'] ?></option>

                    <?php endwhile; ?>

                </select>
            </div>

            <div class="form-group m-3">
                <label for="images">Images</label>
                <input multiple type="file" class="form-control" name="images[]" onchange="loadFile(event)">

                <div id="parent"></div>
            </div>

            <div class="form-group m-3">
                <label for="pays">Pays</label>
                <select type="text" class="form-control" id='pays' name="pays">
                    <option value="" selected>Choisir un pays</option>
                    <option value="France"> France</option>
                    <option value="Allemagne"> Allemagne</option>
                    <option value="Espagne"> Espagne</option>
                </select>
            </div>

            <div class="form-group m-3">
                <label for="ville">Ville</label>
                <select type="text" class="form-control" id='ville' name="ville">
                    <option value="" selected>Choisir une ville</option>
                    <option value="paris"> Paris</option>
                    <option value="Allemagne"> Berlin</option>
                    <option value="Espagne"> Madrid</option>
                </select>
            </div>


            <div class="form-group m-3">
                <label for="adresse">Adresse</label>
                <textarea type="text" class="form-control" id='adresse' name="adresse" placeholder="Adresse de l'annonce"></textarea>
            </div>



            <div class="form-group m-3">
                <label for="cp">Code Postal</label>
                <input type="text" class="form-control" id='cp' name="cp" placeholder="Code postale de l'annonce">
            </div>

            <input type="submit" id="max" class="btn btn-outline-dark" value="Deposer une annonce">

            <div id="message">

            </div>

        </form>

        <?php

        include_once('include/footer.php');
