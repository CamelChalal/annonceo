        <?php

        include_once('include/init.php');

        $tabValue = array();

        if (isset($_GET['id_annonce'])) {

            $pdoStatement = $pdoObject->prepare("SELECT * FROM annonce  INNER JOIN membre on id_membre = membre_id WHERE id_annonce = :id_annonce");
            $pdoStatement->bindValue(":id_annonce", $_GET['id_annonce'], PDO::PARAM_INT);
            $pdoStatement->execute();

            $arrayAnnonce = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            // echo "<pre>";
            // print_r($arrayAnnonce);
            // echo "</pre>";


            $pdoStatement = $pdoObject->query('SELECT * FROM commentaire INNER JOIN membre ON membre_id = id_membre');

            $arrayCommentaire = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

            // echo "<pre>";
            // print_r($arrayCommentaire);
            // echo "</pre>";
        }




        if (!$arrayAnnonce) {
            header('Location: ' . URL . "index.php?annonce=inexistante");
        }

        if (membreConnected()) {

            $membreId2 = $arrayAnnonce['membre_id'];
            $membreId = $_SESSION['membre']['id_membre'];

            if ($_POST) {

                // if (isset($_POST['recherche'])) {
                //     $search = $_POST['recherche'];
                //     $sql = " ( titre LIKE '%" . $search . "%' OR prix LIKE '%" . $search . "%' )";
                // }
                if (!empty($_POST['nom'])  && !empty($_POST['sujet']) && !empty($_POST['message'])) {

                    //entete expediteur
                    $entetes = "From: " . $_POST['nom'] . "\n";
                    // entete adresse de retour
                    $entetes .= "Reply-to:" . "camel.chalal@gmail.com" . "\n";
                    //
                    $entetes .= "MIME-Version: 1.0 \n";

                    $entetes .= "X-priority: 1\n";

                    $entetes .= "Content-type: text/html; charset=utf8\n";

                    $message = "De " . $_POST['nom'] . ", le " . date("d/m/Y H:i:s") . "<br>";

                    $message .= "Objet : <strong>" . $_POST['sujet'] . "</strong><hr>";

                    $message .= $_POST['message'];

                    mail("camel.chalal@gmail.com", $_POST['sujet'], $message, $entetes);

                    $notification = "<div class='col-md-6 mx-auto text-center alert alert-success disparition'>Message envoyé </div>";
                } else {
                    $erreur = "<div class='col-md-6 mx-auto text-center alert alert-danger disparition'> Merci de remplir tous les champs du formulaire<div>";
                }

                if (!empty($_POST['commentaire'])) {

                    $pdoStatement = $pdoObject->prepare('INSERT INTO commentaire (membre_id, annonce_id, commentaire, date_enregistrement) VALUES ( :membre_id, :annonce_id, :commentaire, :date_enregistrement)');


                    $pdoStatement->bindValue(":membre_id", $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
                    $pdoStatement->bindValue(":annonce_id", $_GET['id_annonce'], PDO::PARAM_INT);
                    $pdoStatement->bindValue(":commentaire", $_POST['commentaire'], PDO::PARAM_STR);
                    $pdoStatement->bindValue(":date_enregistrement", date('Y-m-d H:i:s'), PDO::PARAM_STR);


                    $pdoStatement->execute();

                    header("Location:" . URL . "index.php?commentaire=envoyer");
                }

                if (!empty($_POST['note'])) {


                    $pdoStatement = $pdoObject->prepare('INSERT INTO note (membre_id1, membre_id2, note, date_enregistrement) VALUES (:membre_id1, :membre_id2, :note, :date_enregistrement )');

                    $pdoStatement->bindValue(":membre_id1", $membreId, PDO::PARAM_INT);
                    $pdoStatement->bindValue(":membre_id2", $membreId2, PDO::PARAM_INT);
                    $pdoStatement->bindValue(":note", $_POST['note'], PDO::PARAM_INT);
                    $pdoStatement->bindValue(":date_enregistrement", date('Y-m-d H:i:s'), PDO::PARAM_STR);

                    $pdoStatement->execute();

                    header("Location:" . URL . "index.php?note=envoyer");
                }
            }
        } elseif (!membreConnected()) {
            $erreur = "<div class='col-md-6 mx-auto text-center alert alert-warning disparition'>
                                Vous devez être connecté pour contacter le vendeur
                            </div>";
        } else {
            $notification = "<div class='col-md-6 mx-auto text-center alert alert-success disparition'>Message envoyé </div>";
        }

        $pdoStatement = $pdoObject->prepare('SELECT * FROM photo WHERE id_photo = :id_photo');
        $pdoStatement->bindValue(":id_photo", $arrayAnnonce['photo_id'], PDO::PARAM_INT);
        $pdoStatement->execute();

        $arrayPhoto = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        $tabPhoto = [];

        foreach ($arrayPhoto as $key => $photo) {
            if ($key != 'id_photo') {
                if (!empty($photo)) {

                    array_push($tabPhoto, $photo);
                }
            }
        }


        include_once('include/header.php');
        ?>

        <h1 class="text-center m-4"> Annonceo</h1>

        <?= $erreur ?>
        <?= $notification ?>

        <div class="g-0 container">

            <div class="row justify-content-between ">
                <?php if (count($tabPhoto) == 1) : ?>

                    <img class="d-block" style="width: 300px;" src="images/imagesUpload/<?= $tabPhoto[0] ?>" alt="<?= $arrayAnnonce['titre'] ?>">

                <?php elseif (count($tabPhoto) > 1) : ?>


                    <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel" style="width: 300px;">
                        <ol class="carousel-indicators">

                            <?php foreach ($tabPhoto as $key => $photoTab) : ?>

                                <?php if ($key == 0) : ?>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <?php else : ?>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php foreach ($tabPhoto as $key => $photoTab) : ?>

                                <?php if ($key == 0) : ?>
                                    <div class="carousel-item active">
                                        <img class="d-block img-fluid" src="images/imagesUpload/<?= $photoTab ?>">
                                    </div>
                                <?php else : ?>
                                    <div class="carousel-item">
                                        <img class="d-block img-fluid" src="images/imagesUpload/<?= $photoTab ?>">
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Page Content -->

                <div class="col-md-6 ml-4">
                    <h1 class="font-weight-light"><?= $arrayAnnonce['titre'] ?></h1>
                    <p><?= $arrayAnnonce['description_longue'] ?></p>
                    <p><?= $arrayAnnonce['prix'] . '€' ?></p>
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">Contacter
                        <?= $arrayAnnonce['pseudo'] ?></button>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Votre message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <p> <?= $arrayAnnonce['telephone'] ?></p>
                            </div>
                            <form method="post">
                                <div class="form-group">
                                    <label for="nom" class="col-form-label">Expéditeur:</label>
                                    <input type="text" class="form-control" id="nom" name="nom">
                                </div>
                                <div class="form-group">
                                    <label for="sujet" class="col-form-label">Sujet:</label>
                                    <input type="text" class="form-control" id="sujet" name="sujet">
                                </div>
                                <div class="form-group">
                                    <label for="message" class="col-form-label">Message:</label>
                                    <textarea class="form-control" id="message" name="message"></textarea>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-dark col-md-3 mt-1 mb-1">Envoyer</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <!-- /.col-md-4 -->
        </div>
        <!-- /.row -->

        <!-- Call to Action Well -->
        <div class=" card text-white bg-secondary my-5 py-4 text-center">
            <div class="card-body">
                <iframe src="https://maps.google.it/maps?q=<?php echo $arrayAnnonce['adresse']; ?>&output=embed" width="1000" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- Content Row -->
        <div class="g-0 row">
            <div class="col-md-4 mb-5">
                <div class="card h-60">
                    <div class="card-body">
                        <h6 class="card-title">Pour déposer un commentaire</h6>

                    </div>
                    <div class="card-footer">
                        <p>
                            <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Cliquer ici</a>
                        </p>
                        <div class="collapse multi-collapse" id="multiCollapseExample1">
                            <div class="card card-body">
                                <form action="" method="post">
                                    <textarea name="commentaire" id="commentaire" cols="30" rows="5"></textarea>
                                    <button type="submit" class="col-md-4 btn btn-dark btn-sm mt-3 ">envoyer</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-4 mb-5">
                <div class="card h-60">
                    <div class="card-body">
                        <h6 class="card-title">Pour noter <?= $arrayAnnonce['pseudo'] ?> </h6>
                    </div>
                    <div class="card-footer">
                        <p>
                            <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Cliquer ici
                            </a>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <form action="" method="post">

                                    <fieldset class="rating" id="note" name="note">
                                        <input type="radio" id="star5" name="note" value="5" /><label class="full" for="star5" title="Awesome - 5 stars"></label>
                                        <input type="radio" id="star4" name="note" value="4" /><label class="full" for="star4" title="Pretty good - 4 stars"></label>
                                        <input type="radio" id="star3" name="note" value="3" /><label class="full" for="star3" title="Meh - 3 stars"></label>
                                        <input type="radio" id="star2" name="note" value="2" /><label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                                        <input type="radio" id="star1" name="note" value="1" /><label class="full" for="star1" title="Sucks big time - 1 star"></label>
                                    </fieldset><br>
                                    <button type="submit" class=" btn btn-dark btn-sm mt-3 ">envoyer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-4 -->
            <div class="g-0 col-md-4 mb-5">
                <div class="card h-60">
                    <div class="card-body">
                        <h6 class="card-title">Pour voir les commentaires</h6>

                    </div>
                    <div class="card-footer">
                        <p>
                            <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Cliquer ici</a>
                        </p>
                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                            <div class="card card-body">

                                <?php foreach ($arrayCommentaire as $key => $value) : ?>

                                    <?php if ($value['annonce_id'] == ($_GET['id_annonce'])) : ?>
                                        <div class="col text-center">
                                            <?= ucfirst($value['pseudo']) . " :<br>" . $value['commentaire'] . "<hr>" ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-4 -->

        </div>
        <!-- /.row -->

        </div>
        <!-- /.container -->





        <?php

        include_once('include/footer.php');
