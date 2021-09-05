<?php
include_once('include/init.php');


// Sécurité
if (!membreConnected()) {
    header("Location:" . URL . "erreur.php?acces=interdit");
    exit;
}

if (isset($_GET['modification'])) {



    // <!-- PAGE WEB : MODIFIER LE PROFIL -->
    if (isset($_GET['modification']) && ($_GET['modification'] == "profil")) :

        foreach ($_SESSION['membre'] as $key => $value) {


            if (isset($_SESSION['membre'][$key])) {

                $$key = $_SESSION['membre'][$key];
            } else {
                $$key = "";
            }
        }

        if ($_POST) {


            // requete de préparation
            $pdoStatement = $pdoObject->prepare("SELECT * FROM membre WHERE email = :email");
            $pdoStatement->bindValue(":email", $_POST['email'], PDO::PARAM_STR);
            $pdoStatement->execute();

            $id_membrArray = $pdoStatement->fetch(PDO::FETCH_ASSOC);
            //echo "<pre>";print_r($membreArray);echo "</pre>";


            if (!empty($membreArray) && $membreArray['email'] != $_SESSION['membre']['email']) {

                $erreur .= "<div class=' col-md-6 text-center bg-success disparition'>
                                L'email " . $_POST['email'] . " est déja associé à un compte
                            </div>";
            } else {


                //1ere etape
                $pdoStatement = $pdoObject->prepare('UPDATE membre SET email = :email, nom = :nom, prenom= :prenom, pseudo= :pseudo, telephone= :telephone WHERE id_membre = :id_membre');

                //2eme etape
                $pdoStatement->bindValue(":id_membre", $_SESSION['membre']['id_membre'], PDO::PARAM_STR);

                foreach ($_POST as $key => $value) {


                    if (gettype($value) == "string") {

                        $type = PDO::PARAM_STR;
                    } else {

                        $type = PDO::PARAM_INT;
                    }


                    $pdoStatement->bindValue(":$key", $value, $type);
                }
                //3eme etape
                $pdoStatement->execute();

                // changement des valeurs du tableau 'membre' dans la session
                $_SESSION['membre']['email'] = $_POST['email'];
                $_SESSION['membre']['nom'] = $_POST['nom'];
                $_SESSION['membre']['prenom'] = $_POST['prenom'];
                $_SESSION['membre']['pseudo'] = $_POST['pseudo'];
                $_SESSION['membre']['telephone'] = $_POST['telephone'];



                // Création d'un tableau 'notification' dans $_SESSION
                $_SESSION['notification']['profil'] = "modifie";

                // Redirection sur le fiche profil.php

                header('Location:' . URL . "profil.php");
                exit;
            }
        }


        include_once('include/header.php');
?>

        <h1 class="text-center m-4">Modifier le profil</h1>

        <?= $erreur ?>

        <form method="post" class="col-md-6 mx-auto">

            <div class="form-group m-3">
                <label for="email">Email</label>
                <input type="text" class="form-control" id='email' name="email" placeholder="Saisir votre email" value="<?php if (isset($email)) echo $email ?>">
            </div>


            <div class="form-group m-3">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id='nom' name="nom" placeholder="Saisir votre nom" value="<?php if (isset($nom)) echo $nom ?>">
            </div>


            <div class="form-group m-3">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id='prenom' name="prenom" placeholder="Saisir votre prénom" value="<?php if (isset($prenom)) echo $prenom ?>">
            </div>

            <div class="form-group m-3">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" id='pseudo' name="pseudo" placeholder="Saisir un pseudo" value="<?php if (isset($pseudo)) echo $pseudo ?>">
            </div>

            <div class="form-group m-3">
                <label for="telephone">Téléphone</label>
                <input type="text" class="form-control" id='telephone' name="telephone" placeholder="Saisir un telephone" value="<?php if (isset($telephone)) echo $telephone ?>">
            </div>

            <div class="row justify-content-around">
                <input type="submit" class="btn btn-success col-md-5 col-12 m-1" value='Modifier'>
                <a class="btn btn-info col-md-5 col-12 m-1" href="<?= URL ?>profil.php">Retour sur le profil</a>
            </div>

        </form>

    <?php endif; ?>



    <!-- PAGE WEB : MODIFIER LE MOT DE PASSE -->
    <?php if (isset($_GET['modification']) && ($_GET['modification'] == "mdp")) :

        if ($_POST) {

            //1ere condition: comparer le champ ancien mdp avec le mdp de la $_SESSION
            if (password_verify($_POST['old_mdp'], $_SESSION['membre']['mdp'])) {

                //2eme condition : comparer les 2 nouveaux mdp
                if ($_POST['new_mdp'] == $_POST['confirm_new_mdp']) { //si ils sont identiques

                    //3eme condition : les new mdp ne sont pas vides
                    if (!empty($_POST['new_mdp'])) {

                        //4eme condition : le new mpd est different de l'ancien
                        if ($_POST['new_mdp'] != $_POST['old_mdp']) {


                            //hash du nouveau mdp
                            $_POST['new_mdp'] = password_hash($_POST['new_mdp'], PASSWORD_DEFAULT);

                            //requete de preparation de modification 
                            //1ere etapes 
                            $pdoStatement = $pdoObject->prepare('UPDATE membre SET mdp = :mdp WHERE id_membre = :id_membre');
                            //2e etape 
                            $pdoStatement->bindValue(":id_membre", $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
                            $pdoStatement->bindValue(":mdp", $_POST['new_mdp'], PDO::PARAM_STR);
                            //3e etape 
                            $pdoStatement->execute();

                            //changer la valeur du mdp dans la $_SESSION
                            $_SESSION['membre']['mdp'] = $_POST['new_mdp'];

                            // Création d'un tableau "notification" dans la $_SESSION
                            $_SESSION['notification']['mdp'] = "modifie";

                            // redirection sur la page profil.php
                            header('Location:' . URL . 'profil.php');
                            exit;
                        } else { // else de la 4eme conditions

                            $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                                            Veuillez saisir un mot de passe différent de l'ancien
                                        </div>";
                        }
                    } else { //else de la 3eme conditions

                        $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                                            Veuillez saisir un mot de passe
                                    </div>";
                    }
                } else { //else de la 2eme conditions : les mdp ne sont pas identiques

                    $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                                        les mots de passes ne sont pas identiques
                                    </div>";
                }
            } else { //else de la 1ere condition : ancien de mot de passe incorrect

                $erreur .= "<div class='col-md-6 mx-auto alert alert-danger text-center'>
                                    Ancien mot de passe incorrect
                            </div>";
            }
        }




        include_once('include/header.php');
    ?>

        <h1 class="text-center m-4">Modifier le mot de passe</h1>

        <?= $notification ?>

        <form method="post" class="col-md-6 mx-auto text-center">

            <div class="form-group m-3">
                <label for="old_mdp">Ancien mot de passe</label>
                <input type="text" class="form-control" id='old_mdp' name="old_mdp" placeholder="Saisir votre ancien mot de passe">
            </div>

            <div class="form-group m-3">
                <label for="new_mdp">Nouveau mot de passe</label>
                <input type="text" class="form-control" id='new_mdp' name="new_mdp" placeholder="Saisir votre nouveau mot de passe">
            </div>
            <div class="form-group m-3">
                <label for="confirm_new_mdp">Confirmez le nouveau mot de passe</label>
                <input type="text" class="form-control" id='confirm_new_mdp' name="confirm_new_mdp" placeholder="Confirmer votre nouveau mot de passe">
            </div>

            <div class="row mx-auto text-center">
                <input type="submit" class="btn btn-success col-md-5 col-12 m-1" value='Modifier'>
                <a class="btn btn-info col-md-5 col-12 m-1" href="<?= URL ?>profil.php">Retour sur le profil</a>
            </div>
        </form>



    <?php endif; ?>


<?php
    include_once('include/footer.php');
} else {
    header("Location:" . URL . "erreur.php?page=inexistante");
    exit;
}
