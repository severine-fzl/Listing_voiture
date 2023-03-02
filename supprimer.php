<!-- SUPPRESSION D'UN SEUL ENREGISTREMENT AVEC LE BOUTON SUPPRIMER  -->

<?php
session_start();
require "base_de_donnees/bdd_mysql.php";

$delete1 = $db->prepare("DELETE FROM `voiture` WHERE id = :id");
$delete1->execute(array("id" => $_GET["id"]));

$delete2 = $db->prepare("DELETE FROM `conducteur` WHERE id = :id");
$delete2->execute(array('id' => $_GET['id']));

if ($delete1 && $delete2) {
    $_SESSION['status'] = "<script>alert(\"La suppression a bien été effectué !\")</script>";
    header("Location:index.php");
}

// SUPPRESSION SEUL OU MULTIPLE AVEC CASE A COCHER

$conn = mysqli_connect("localhost", "root", "", "liste_voiture");

if (isset($_POST['delete'])) {
    $all_id = $_POST['delete_id'];
    $extract_id = implode(',', $all_id);
    echo $extract_id;

    //PREPARATION DES REQUETES ET EXECUTION
    $query_voiture = "DELETE FROM voiture WHERE id IN($extract_id)";
    $query_conducteur = "DELETE FROM conducteur WHERE id IN($extract_id)";
    $query_run_voiture = mysqli_query($conn, $query_voiture);
    $query_run_conducteur = mysqli_query($conn, $query_conducteur);

    if ($query_run_voiture && $query_run_conducteur) {
        $_SESSION['status'] = "<script>alert(\"La suppression a bien été effectué !\")</script>";
    } else {
        $_SESSION['status'] = "<script>alert(\"Vous n'avez rien selectionné !\")</script>";
    }
    header("Location:index.php");
}
?>