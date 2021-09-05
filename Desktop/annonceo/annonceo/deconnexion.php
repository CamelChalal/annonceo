<?php

include_once('include/init.php');



if (!membreConnected()) {
    header("location:" . URL . "erreur.php?acces=interdit");
    exit;
}



session_destroy();

// redirection 

header("Location:" . URL . "connexion.php");
exit;
