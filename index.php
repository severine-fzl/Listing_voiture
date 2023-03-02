<?php
session_start(); ?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing voiture</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style_index.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/a3fe021618.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php
    $marque = isset($_POST['marque']) ? $_POST['marque'] : "";
    $modele = isset($_POST['modele']) ? $_POST['modele'] : "";
    $couleur = isset($_POST['couleur']) ? $_POST['couleur'] : "";
    $annee = isset($_POST['annee']) ? $_POST['annee'] : "";
    $principal_secondaire = isset($_POST['principal_secondaire']) ? $_POST['principal_secondaire'] : "";
    $civilite = isset($_POST['civilite']) ? $_POST['civilite'] : "";
    $nom = isset($_POST['nom']) ? $_POST['nom'] : "";
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : "";
    $dateAjout = isset($_POST['dateAjout']) ? $_POST['dateAjout'] : "";
    $dateModification = isset($_POST['dateModification']) ? $_POST['dateModification'] : "";

    require "base_de_donnees/bdd_mysql.php";

    // lancement de la requete sur la table voiture
    $infoVoiture = $db->prepare('SELECT * FROM voiture INNER JOIN conducteur ON conducteur.id = voiture.id');
    $executeIsOkVoiture = $infoVoiture->execute();
    $voitures = $infoVoiture->fetchAll();
    ?>

    <h1>Liste des voitures </h1>

    <?php
    if (isset($_SESSION['status'])) {
        echo "<h4>" . $_SESSION['status'] . "</h4>";
        unset($_SESSION['status']);
    }
    ?>

    <div class="ajouter">
        <a href="ajouter.php">
            <button class="btnAjoutVoiture">Ajouter une voiture</button>
        </a>
    </div>

    <form action="supprimer.php" method="post">

        <?php
        if ($voitures) { ?>
            <div class="supprimer">
                <button class="btnSupprVoiture" type="submit" name="delete">Supprimer</button>
            </div>
        <?php
        } else {
        ?>
            <div class="supprimer">
                <button class="btnSupprVoiture" type="submit" name="delete" style="visibility: hidden"></button>
            </div>
        <?php
        }

        if ($voitures) { ?>
            <div class="selectionner">
                <input class="btnSelectionner" type="button" value="Tout selectionner" onClick="checkAll('delete_id[]', true);">
            </div>
        <?php
        } else {
        ?>
            <div class="selectionner">
                <input class="btnSelectionner" type="button" value="Tout selectionner" onClick="checkAll('delete_id[]', true);" style="visibility: hidden">
            </div>
        <?php
        }
        ?>

        <div class="formulaire">
            <?php
            $conn = mysqli_connect("localhost", "root", "", "liste_voiture");
            $query = "SELECT * FROM voiture INNER JOIN conducteur ON conducteur.id = voiture.id";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
                foreach ($voitures as $voiture) {
            ?>
                    <ul>
                        <li>
                            <div class="check"><input class="input" type="checkbox" name="delete_id[]" value="<?= $voiture['id']; ?>"></div>
                            Informations sur la voiture : <?= $voiture['marque'] ?> <?= $voiture['modele'] ?> de couleur <?= $voiture['couleur'] ?>, année <?= $voiture['annee'] ?>.<br>
                            Informations sur le conducteur : Le conducteur <?= $voiture['principal_secondaire'] ?> est <?= $voiture['civilite'] ?> <?= $voiture['nom'] ?> <?= $voiture['prenom'] ?>.
                        </li>
                    </ul>
                    <div class="icone">
                        <a href="supprimer.php?id=<?= $voiture['id'] ?>"><i class="fa-solid fa-circle-xmark"></i></a>
                        <a href="modifier.php?id=<?= $voiture['id'] ?>"><i class="fa-solid fa-pencil"></i></a><br>
                    </div>

                    <div class="dateAjout">Ajouté le :
                        <?= $voiture['dateAjout']; ?><br>
                        <?php
                        $dateModification = (isset($voiture['dateModification']) ? ' Modifié le : ' . $voiture['dateModification'] : '');
                        echo $dateModification; ?><br><br></div>
                    <div class="trait"></div>
                <?php
                }
            } else {
                ?>
                <p class="noVoiture">Il n'y a actuellement aucune voiture enregistrée.</p>
            <?php
            }
            ?>
        </div>
    </form>
    <script src="script.js"> </script>
</body>

</html>