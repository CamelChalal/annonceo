<?php

include_once('include/init.php');


if (membreConnected()) {
    header("location:" . URL . "erreur.php?acces=interdit");
    exit;
}

if (isset($_GET['compte']) && ($_GET['compte'] == 'enregistre')) {

    $notification .= "<div class='col-md-6 mx-auto alert alert-success text-center disparition'>
                             Votre inscription a été enregistrée
                        </div>";
}

if ($_POST) {


    if (!empty($_POST['email'])) {


        $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
        $pdoStatement->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
        $pdoStatement->execute();

        $membreArray = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        //1ere condition pour la connexion : verifier que l'email existe en bdd
        if (!empty($membreArray)) {

            //2eme condition : comparer le mdp du formulaire a celui associé en bdd associé a l'email

            if (password_verify($_POST['mdp'], $membreArray['mdp'])) {

                foreach ($membreArray as $key => $value) {

                    $_SESSION['membre'][$key] = $value;
                }

                // redirection


                // si le statut est égal à 1 (client)
                if ($_SESSION['membre']['statut'] == 1) {
                    header("Location:" . URL . "profil.php");
                    exit;
                } else // si le statut est égal à 2 (admin)
                {
                    header("Location:" . URL . "admin/gestion_annonces.php");
                    exit;
                }
            } else {

                $erreur .= "<div class=' col-md-6 mx-auto text-center bg-warning disparition'>
                                        Mot de passe incorrect
                                    </div>";
            }
        } else {

            $erreur .= "<div class=' col-md-6 mx-auto text-center bg-warning disparition'>
                                            L'email " . $_POST['email'] . " n'est pas associé à un compte <br>
                                            Veuillez vous inscrire
                                            </div>";
        }
    } else {

        $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center disparition'>
                    Veuillez saisir un email
                </div>";
    }
}







include_once('include/header.php');
?>

<h1 class="text-center m-4">Connexion</h1>

<?= $erreur ?>
<?= $notification ?>

<form method="post" class="col-md-4 mx-auto text-center">

    <div class="form-group m-3">
        <label for="email">Email</label>
        <input type="text" class="form-control" id='email' name="email" placeholder="Saisir un email">
    </div>

    <div class="form-group m-3">
        <label for="mdp">Mot de passe</label>
        <input type="text" class="form-control" id='mdp' name="mdp" placeholder="Saisir un mot de passe">
    </div>

    <button type="submit" class="col-md-12 btn btn-dark mt-3">Connexion</button>

</form>


<?php

include_once('include/footer.php');
