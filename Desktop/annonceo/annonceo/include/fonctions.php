<?php

// Sécurité

// statut 1 = CLIENT 
// statut 2 = ADMIN


// Pour savoir si un membre est connecté, on vérifie s'il y a le tableau 'membre' dans la $_SESSION
// car c'est UNIQUEMENT dans la connexion qu'on créé ce tableau 'membre'



// ----- FONCTION MEMBRE CONNECTÉ 

// ----- tout membre confondu (pas de distinction sur le champ statut)
// ----- Qu'on soit client ou admin : on est tout d'abord un membreConnecte
function membreConnected()
{
    // si le tableau 'membre' est défini et non null dans la $_SESSION
    if (isset($_SESSION['membre'])) // true
    {
        return true; // l'utilisateur est connecté
    } else // false
    {
        return false; // l'utilisateur n'est pas connecté
    }
}




// ----- FONCTION ADMIN CONNECTÉ

// la différence entre un client et un admion est le statut
// un admin reste de base un membreConnecte


function adminConnected()
{

    if (membreConnected() && $_SESSION['membre']['statut'] == 2) {
        return true;
    } else {
        return false;
    }
}
