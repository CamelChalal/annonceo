<?php

include_once('include/init.php');


if (membreConnected()) {
    header("location:" . URL . "erreur.php?acces=interdit");
    exit;
}

if ($_POST) {

    if (!empty($_POST['email'])) {



        //1ere etape: preparation de la requete
        $pdoStatement = $pdoObject->prepare('SELECT * FROM membre WHERE email = :email');
        //2eme etape: association des marqueurs
        $pdoStatement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        //3eme etape :execution
        $pdoStatement->execute();


        $membreArray = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        if (empty($membreArray)) {

            if (!empty($_POST['pseudo'])) {



                //1ere etape: preparation de la requete
                $pdoStatement = $pdoObject->prepare('SELECT * FROM membre WHERE pseudo = :pseudo');
                //2eme etape: association des marqueurs
                $pdoStatement->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                //3eme etape :execution
                $pdoStatement->execute();


                $membreArray = $pdoStatement->fetch(PDO::FETCH_ASSOC);

                //1ere condition : si le tableau est vide
                if (empty($membreArray)) {

                    if ($_POST['mdp'] == $_POST['confirm_mdp']) { // 2eme conditions :verifier si les mdp sont identique

                        if (!empty($_POST['mdp'])) { // 3eme condition : les mdp sont identiques et non vides

                            if (!empty($_POST['telephone']) && is_numeric($_POST['telephone'])) { // 5eme condition : le telephone est vide

                                //insertion dans la table membre

                                $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);



                                // PREPARATION DE LA REQUETE 

                                // 1e étape 
                                $pdoStatement = $pdoObject->prepare('INSERT INTO membre (email, mdp, nom, prenom, statut, pseudo, telephone, civilite, date_enregistrement) VALUES (:email, :mdp, :nom, :prenom, :statut, :pseudo, :telephone, :civilite, :date_enregistrement)');

                                // 2e étape 

                                foreach ($_POST as $key => $value) {

                                    if ($key != "confirm_mdp") { //on ejecte confirm_mdp de la boucle


                                        if (gettype($value) == "string") {

                                            $type = PDO::PARAM_STR;
                                        } else {

                                            $type = PDO::PARAM_INT;
                                        }


                                        $pdoStatement->bindValue(":$key", $value, $type);
                                    }
                                }
                                // par défaut lorsqu'un utilisateur s'inscrit il a le statut 1
                                // statut = 1 : membre/client
                                // statut = 2 : admin
                                $pdoStatement->bindValue(":statut", 1, PDO::PARAM_STR);
                                $pdoStatement->bindValue(":date_enregistrement", date('Y-m-d H:i:s'), PDO::PARAM_STR);


                                // 3e étape :

                                $pdoStatement->execute();

                                //redirection vers la page connexion

                                header("location:" . URL . "connexion.php?compte=enregistre");
                                exit;

                                $notification .= "<div class='col-md-6 mx-auto alert alert-success text-center disparition'>
                                                                        Votre inscription a été enregistrée
                                                                    </div>";
                            } else { //else de la 5eme condition

                                $erreur .= "<div class=' col-md-6 mx-auto text-center alert alert-danger disparition'>
                                                        Veuillez saisir votre numéro de téléphone
                                                </div>";
                            }
                        } else { // else de la 3eme conditions 

                            $erreur .= "<div class=' col-md-6 mx-auto text-center alert alert-danger disparition'>
                                                Veuillez saisir un mot de passe
                                            </div>";
                        }
                    } else { // else de la 2eme conditions
                        $erreur .= "<div class=' col-md-6 mx-auto text-center alert alert-danger disparition'>
                                            Les mots de passe ne sont pas identiques
                                        </div>";
                    }
                } else { //else de la 1ere condition
                    $erreur .= "<div class=' col-md-6 mx-auto text-center bg-warning disparition'>
                                        Le pseudo " . $_POST['pseudo'] . " est déja associé à un compte
                                    </div>";
                }
            } else {
                $erreur .= "<div class=' col-md-6 mx-auto text-center alert alert-danger disparition'>
                                    Veuillez saisir un pseudo
                                </div>";
            }
        } else { //else de la 1ere condition
            $erreur .= "<div class=' col-md-6 mx-auto text-center bg-warning disparition'>
                                        L'email " . $_POST['email'] . " est déja associé à un compte
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

<h1 class="text-center m-4">INSCRIPTION</h1>
<?= $erreur ?>
<?= $notification ?>

<form method="post" class="col-md-4 mx-auto text-center">

    <div class="form-group m-3">
        <input type="text" class="form-control" id='pseudo' name="pseudo" placeholder="Votre pseudo">
    </div>

    <div class="form-group m-3">
        <input type="text" class="form-control" id='email' name="email" placeholder="Saisir un email">
    </div>

    <div class="form-group m-3">
        <input type="text" class="form-control" id='mdp' name="mdp" placeholder="Saisir un mot de passe">
    </div>

    <div class="form-group m-3">
        <input type="text" class="form-control" id='confirm_mdp' name="confirm_mdp" placeholder="Confirmer le mot de passe">
    </div>

    <div class="form-group m-3">
        <input type="text" class="form-control" id='nom' name="nom" placeholder="Saisir votre nom">
    </div>

    <div class="form-group m-3">
        <input type="text" class="form-control" id='prenom' name="prenom" placeholder="Saisir votre prénom">
    </div>
    <div class="form-group m-3">
        <input type="text" class="form-control" id='telephone' name="telephone" placeholder="Votre Téléphone">
    </div>

    <div class="form-group m-3">
        <select style="width: 305px; height: 30px;" name="civilite" id="civilite">
            <option value="m">Homme</option>
            <option value="f">Femme</option>
        </select>
    </div>

    <button type="submit" class="col-md-6 btn btn-dark mt-3 mb-5">Inscription</button>

</form>





<?php

include_once('include/footer.php');
