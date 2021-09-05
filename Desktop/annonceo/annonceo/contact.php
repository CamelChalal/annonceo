    <?php

    include_once('include/init.php');

    $message = "";

    if ($_POST) {

        if (!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['sujet']) && !empty($_POST['message'])) {

            //fonction prédéfinie php mail(), elle permet d'envoyer des emails
            //4 arguments: 1. destinataire 2. objet 3.message 4.entetes

            //entete expediteur
            $entetes = "From: " . $_POST['email'] . "\n";
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
    }




    include_once('include/header.php');
    ?>

    <h1 class="text-center m-4">Contact</h1>
    <p class="text-center">Une remarque ? une suggestion ? N'hésitez-pas à nous contacter</p>

    <?= $erreur ?>
    <?= $notification ?>

    <form method="post" class="col-md-4 mx-auto text-center">

        <div class="form-group m-3">
            <label for="nom">votre nom</label>
            <input type="text" class="form-control" id='nom' name="nom" placeholder="Saisir votre nom">
        </div>
        <div class="form-group m-3">
            <label for="email">votre e-mail</label>
            <input type="email" class="form-control" id='email' name="email" required placeholder="Saisir un email">
        </div>

        <div class="form-group m-3">
            <label for="sujet">sujet</label>
            <input type="text" class="form-control" id='sujet' name="sujet" placeholder="quel sujet">
        </div>
        <div class="form-group m-3">
            <label for="message">Votre message</label>
            <textarea type="text" class="form-control" id='message' name="message" placeholder="Saisir votre message"></textarea>
        </div>

        <button type="submit" class="col-md-7 btn btn-dark mt-2 mb-5">Envoyer</button>

    </form>



    <?php

    include_once('include/footer.php');
