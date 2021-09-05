<?php

//---------------- CONNEXION A LA BDD   

$pdoObject = new PDO('mysql:host=localhost; dbname=annonceo', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


//------------------CHEMINS

define("URL", "http://localhost/annonceo/");

define("RACINE_IMAGES", $_SERVER['DOCUMENT_ROOT'] . "/annonceo/images/imagesUpload/");

// -----------------VARIABLES

$notification = '';
$erreur = '';

$sql = ['1 = 1'];

$trie = " ORDER BY RAND()";

//-----------------OUVERTURE DE LA SESSION

session_start();


//------------------ FAILLES XSS

foreach ($_POST as $key => $value) {
    if (is_array($_POST[$key])) {
        foreach ($_POST[$key] as $k => $v) {
            $_POST[$k] = strip_tags(trim($v));
        }
    } else {
        $_POST[$key] = strip_tags(trim($value));
    }
}

//-------------------INCLUSIONS

require_once('fonctions.php');


// ------------- TEST DES SUBERGLOBALES 
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";


    // if(membreConnected())
    // {
    //     echo "Connecté";
    // }
    // else
    // {
    //     echo "Déconnecté";
    // }