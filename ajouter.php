<?php

//On traite le formulaire

if (!empty($_POST)) {
    //POST n'est pas vide, on vérifie que toutes les données sont présentes

    if (
        isset($_POST["marque"], $_POST["modele"], $_POST["couleur"], $_POST["annee"], $_POST["principal_secondaire"], $_POST["civilite"], $_POST["nom"], $_POST["prenom"])
        && !empty($_POST["marque"]) && !empty($_POST["modele"]) && !empty($_POST["couleur"]) && !empty($_POST["annee"]) && !empty($_POST["principal_secondaire"]) && !empty($_POST["civilite"]) && !empty($_POST["nom"]) && !empty($_POST["prenom"])
    ) {
        //Le formulaire est complet
        //On récupère les données en les protégeant (failles XSS)
        $marque = strip_tags($_POST["marque"]);
        $modele = strip_tags($_POST["modele"]);
        $couleur = strip_tags($_POST["couleur"]);
        $annee = strip_tags($_POST["annee"]);
        $principal_secondaire = strip_tags($_POST["principal_secondaire"]);
        $civilite = strip_tags($_POST["civilite"]);
        $nom = strip_tags($_POST["nom"]);
        $prenom = strip_tags($_POST["prenom"]);

        //On peut les enregistrer
        //On se connecte à la base de données
        require "base_de_donnees/bdd_mysql.php";

        //On écrit la requête
        $sql = "INSERT INTO `voiture`(`marque`, `modele`, `couleur`, `annee`, `dateAjout`) VALUES (:marque, :modele, :couleur, :annee, NOW())";
        $sql2 = "INSERT INTO `conducteur`(`principal_secondaire`, `civilite`, `nom`, `prenom`, `dateAjout`) VALUES (:principal_secondaire, :civilite, :nom, :prenom, NOW())";

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
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire - Ajouter un voiture</title>
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
            <input type="text" name="marque" id="marque" placeholder="Marque de la voiture" required> <br>

            <!-- <label for="modele">Modèle de la voiture :</label> -->
            <input type="text" name="modele" id="modele" placeholder="Modèle de la voiture" required><br>

            <!-- <label for="marque">Couleur de la voiture :</label> -->
            <input type="text" name="couleur" id="couleur" placeholder="Couleur de la voiture" required><br>

            <!-- <label for="annee">Année de la voiture :</label> -->
            <input type="text" name="annee" id="annee" placeholder="Année de la voiture" required><br>

            <!-- <label for="principal_secondaire" >Conducteur de la voiture :</label>  -->
            <p>Informations sur le conducteur</p>
            <select name="principal_secondaire" required>
                <option value="">Type de conducteur</option>
                <option value="principal">Principal</option>
                <option value="secondaire">Secondaire</option>
            </select><br>

            <select name="civilite" required>
                <option value="">Civilité</option>
                <option value="Monsieur">Monsieur</option>
                <option value="Madame">Madame</option>
            </select><br>

            <input type="text" name="nom" placeholder="Nom de famille" required> <br>
            <input type="text" name="prenom" placeholder="Prénom" required><br>

            <button class="ajouterAnnuler" type="submit" name="ajouter">Ajouter</button>

            <a href="index.php">
                <input type="button" class="ajouterAnnuler" value="Annuler l'ajout">
            </a>
        </form>
    </div>
</body>
</html>