<?php

require "base_de_donnees/bdd_mysql.php";

if (!empty($_POST)) {
    //POST n'est pas vide, on vérifie que toutes les données sont présentes

    if (
        isset($_POST["marque"], $_POST["modele"], $_POST["couleur"], $_POST["annee"], $_POST["principal_secondaire"], $_POST["civilite"], $_POST["nom"], $_POST["prenom"])
        && !empty($_POST["marque"]) && !empty($_POST["modele"]) && !empty($_POST["couleur"]) && !empty($_POST["annee"]) && !empty($_POST["principal_secondaire"]) && !empty($_POST["civilite"]) && !empty($_POST["nom"]) && !empty($_POST["prenom"])
    ) {
        //Le formulaire est complet
        //On récupère les données
        $marque = $_POST["marque"];
        $modele = $_POST["modele"];
        $couleur = $_POST["couleur"];
        $annee = $_POST["annee"];
        $principal_secondaire = $_POST["principal_secondaire"];
        $civilite = $_POST["civilite"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];

        //On écrit la requête
        $sql = "UPDATE `voiture` SET marque = :marque, modele = :modele, couleur = :couleur, annee = :annee, dateModification = NOW() WHERE id=" . $_GET['id'];
        $sql2 = "UPDATE `conducteur` SET principal_secondaire = :principal_secondaire, civilite = :civilite, nom = :nom, prenom = :prenom, dateModification = NOW() WHERE id=" . $_GET['id'];

        //On prépare la requête
        $query = $db->prepare($sql);
        $query2 = $db->prepare($sql2);

        //On injecte les valeurs
        $query->bindValue(":marque", $marque, PDO::PARAM_STR);
        $query->bindValue(":modele", $modele, PDO::PARAM_STR);
        $query->bindValue(":couleur", $couleur, PDO::PARAM_STR);
        $query->bindValue(":annee", $annee, PDO::PARAM_STR);
        $query2->bindValue(":principal_secondaire", $principal_secondaire, PDO::PARAM_STR);
        $query2->bindValue(":civilite", $civilite, PDO::PARAM_STR);
        $query2->bindValue(":nom", $nom, PDO::PARAM_STR);
        $query2->bindValue(":prenom", $prenom, PDO::PARAM_STR);

        //On exécute la requête
        if (!$query->execute()) {
            die("Une erreur est survenue");
        }
        if (!$query2->execute()) {
            die("Une erreur est survenue sur la query2");
        }

        header("Location:index.php");
    }
}

$sql = $db->prepare("SELECT * FROM voiture INNER JOIN conducteur ON conducteur.id = voiture.id WHERE voiture.id=" . $_GET['id']);
$sql->execute();
//ON PRECISE L'INDEX 0 CAR LE FILTRE SE FAIT SUR L'ID DONC IL N'Y A QU'UNE SEULE ENTREE PAR ID
$donnees = $sql->fetchAll()[0];

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire - Modifier une voiture</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
</head>

<body>

    <div class="formulaire">
        <h1>Ajouter votre voiture</h1>
        <form action="" method="post">
            <p>Informations sur la voiture</p>
            <!-- <label for="marque">Marque de la voiture :</label> -->
            <input type="text" name="marque" id="marque" placeholder="Marque de la voiture" value=<?= $donnees['marque'] ?>> <br>

            <!-- <label for="modele">Modèle de la voiture :</label> -->
            <input type="text" name="modele" id="modele" placeholder="Modèle de la voiture" value=<?= $donnees['modele'] ?>> <br>

            <!-- <label for="marque">Couleur de la voiture :</label> -->
            <input type="text" name="couleur" id="couleur" placeholder="Couleur de la voiture" value=<?= $donnees['couleur'] ?>> <br>

            <!-- <label for="annee">Année de la voiture :</label> -->
            <input type="text" name="annee" id="annee" placeholder="Année de la voiture" value=<?= $donnees['annee'] ?>> <br>

            <!-- <label for="principal_secondaire" >Conducteur de la voiture :</label>  -->

            <p>Informations sur le conducteur</p>
            <select name="principal_secondaire"> <br>
                <option value="">Type de conducteur</option>
                <option value="principal" <?= $donnees['principal_secondaire'] === 'principal' ? 'selected' : '' ?>>Principal</option>
                <option value="secondaire" <?= $donnees['principal_secondaire'] === 'secondaire' ? 'selected' : '' ?>>Secondaire</option>
            </select><br>

            <select name="civilite">
                <option><br>Civilité</option>
                <option value="Monsieur" <?= $donnees['civilite'] === 'Monsieur' ? 'selected' : '' ?>>Monsieur</option>
                <option value="Madame" <?= $donnees['civilite'] === 'Madame' ? 'selected' : '' ?>>Madame</option>
            </select><br>

            <input type="text" name="nom" placeholder="Nom de famille" value=<?= $donnees['nom'] ?>> <br>
            <input type="text" name="prenom" placeholder="Prénom" value=<?= $donnees['prenom'] ?>> <br>

            <button class="ajouterAnnuler" type="submit" name="ajouter">Modifier</button>

            <a href="index.php">
                <input type="button" class="ajouterAnnuler" value="Annuler la modification"></button>
            </a>
        </form>
    </div>
</body>

</html>