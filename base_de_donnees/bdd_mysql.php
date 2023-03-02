<?php

//Constantes d'environnements
define("DBHOST", "localhost");
define("DBUSER", "root");
// define("DBPASS", "severinefuzely2022");
define("DBPASS", "");
define("DBNAME", "liste_voiture");

//DSN (DATA SOURCE NAME) DE CONNEXION
$dsn = "mysql:dbname=".DBNAME.";host=".DBHOST;

//On se connecte à la base
try {
    //On instancie PDO
    $db = new PDO($dsn, DBUSER, DBPASS);

    //On s'assure d'envoyer les données en UTF8
    $db->exec("SET NAMES utf8");

    //On définit le mode de "fetch" par défaut

    $db->setAttribute (PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

}catch(PDOException $e){
    die("Erreur: ".$e->getMessage());
}

//Ici on est connectés à la base
//On peut récupérer la liste des users

$sql = "SELECT * FROM `voiture`";

//On exécute directement la requête

$requete = $db->query($sql);

//On récupère les données
$voiture = $requete->fetch();

?>