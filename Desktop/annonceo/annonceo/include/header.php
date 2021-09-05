<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonceo</title>



    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <!-- Bootstrap core CSS -->


    <!-- Custom styles for this template -->
    <link href="css/small-business.css" rel="stylesheet">

    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css">
    <link rel="stylesheet" href="../include/jquery/jquery-ui.css" type="text/css" media="all" />
    <link rel='stylesheet' href="<?= URL ?>../annonceo/include/css/style.css">




</head>

<body>

    <div class="g-0">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?= URL ?>index.php">Annonceo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto align-items-center">

                    <li class="nav-item active">
                        <a class="nav-link" href="<?= URL ?>qui_somme_nous.php">Qui Sommes Nous</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= URL ?>contact.php">Contact</a>
                    </li>
                    <form action="recherche.php" method="post">
                        <li class="nav-item active ml-5">
                            <input type="text" id="recherche" name="recherche" placeholder="Recherche">
                            <input type="submit" value="recherche">
                        </li>
                    </form>
                    <!-- les liens communs qu'on soit connecté ou non -->

                </ul>


                <ul class="navbar-nav ml-auto mr-5">

                    <!-- si on est connecté et de statut 1 ==> CLIENT CONNECTÉ -->
                    <?php if (membreConnected() && $_SESSION['membre']['statut'] == 1) : ?>

                        <li class="nav-item dropdown pr-5">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $_SESSION['membre']['prenom'] ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="<?= URL ?>profil.php">Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>deposer_annonce.php">Déposer une annonce</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>deconnexion.php">Déconnexion</a>
                            </div>
                        </li>

                        <!-- sinon si on est connecté et de statut 2 ==> ADMIN CONNECTÉ -->
                    <?php elseif (adminConnected()) : ?>

                        <li class="nav-item dropdown pr-5">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>admin/gestion_annonces.php?action=afficher">Gestion des annonces</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>admin/gestion_categories.php">Gestion des catégories</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>admin/gestion_commentaires.php">Gestion des commentaires</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>admin/gestion_membres.php">Gestion des membres</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>admin/gestion_notes.php">Gestion des notes</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>admin/statistiques.php">Statistiques</a>
                                <div class="dropdown-divider"></div>
                                <a class="nav-link" href="<?= URL ?>deconnexion.php">Déconnexion</a>
                            </div>
                        </li>

                        <!-- sinon on n'est pas connecté ==> ANONYMOUS  -->
                    <?php else : ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= URL ?>inscription.php">Inscription</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= URL ?>connexion.php">Connexion</a>
                        </li>

                    <?php endif; ?>

                </ul>
            </div>
        </nav>