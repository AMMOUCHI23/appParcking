<?php
session_start();
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Paris');
include ("config/connexionDb.php");
connect_base_pdo();

if (isset($_POST["envoyer"])) {
    try {
        $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $place=$_POST["place"];
    $matricule=$_POST["matricule"];
    $mobile=$_POST["mobile"];
    $dateEntre=date("Y/m/d  H:i:s");

    
    $sql="INSERT INTO reservations( num_place, matricule, nom, prenom, mobile, date_entre ) 
    VALUES (:num_place, :matricule, :nom, :prenom, :mobile, :date_entre )";
    $requete=$db->prepare($sql);
    $requete->bindParam(':num_place',$place,PDO::PARAM_INT);
    $requete->bindParam(':matricule',$matricule,PDO::PARAM_STR);
    $requete->bindParam(':nom',$nom,PDO::PARAM_STR);
    $requete->bindParam(':prenom',$prenom,PDO::PARAM_STR);
    $requete->bindParam(':mobile',$mobile,PDO::PARAM_STR);
    $requete->bindParam(':date_entre',$dateEntre,PDO::PARAM_STR);
    $requete->execute();

    $statut="occupée";

    $sql="UPDATE places SET statut=:statut WHERE num_place=:num_place";
    $requete=$db->prepare($sql);
    $requete->bindParam(':num_place',$place,PDO::PARAM_INT);
    $requete->bindParam(':statut', $statut,PDO::PARAM_STR);
    $requete->execute();

    $_SESSION["message"]="Réservation réussie";
    header('location:index.php');
    exit;
    } catch (Exception $e) {
        echo "Erreur ".$e->getMessage();
    }
    

}
if (isset($_POST['payer'])) {
    try {
        $montant=$_POST['montant'];
    $modePaiement=$_POST['mode_paiement'];
    $numPlace=$_POST['num_place'];
    $reservationId=$_POST['reservation_id'];
    $dateSortie=date("Y/m/d  H:i:s");

    // Insertion des données dans la table paiements
    $sql="INSERT INTO paiements (resrvation_id, montant, date_paiement, mode_paiement) 
    VALUES (:resrvation_id, :montant, :date_paiement, :mode_paiement)";
     $requete=$db->prepare($sql);
     $requete->bindParam(':resrvation_id',$reservationId, PDO::PARAM_INT);
     $requete->bindParam(':montant', $montant, PDO::PARAM_STR);
     $requete->bindParam(':date_paiement',$dateSortie, PDO::PARAM_STR);
     $requete->bindParam(':mode_paiement', $modePaiement, PDO::PARAM_STR);
     $requete->execute();

    //mise à jour de la table reservations
    $sql="UPDATE reservations SET date_sortie=:date_sortie WHERE num_place=:num_place ";
    $requete=$db->prepare($sql);
    $requete->bindParam(':date_sortie',$dateSortie, PDO::PARAM_STR);
    $requete->bindParam(':num_place', $numPlace, PDO::PARAM_INT);
    $requete->execute();
     
    // mise à jour de la table places
    $statut="libre";
    $sql="UPDATE places SET statut=:statut WHERE num_place=:num_place";
    $requete=$db->prepare($sql);
    $requete->bindParam(':statut',$statut, PDO::PARAM_STR);
    $requete->bindParam(':num_place', $numPlace, PDO::PARAM_INT);
    $requete->execute();

    $_SESSION["message"]="Paiement effectuer avec succés!";
    header('location:index.php');
    exit;
    } catch (Exception $e) {
        echo "Erreur ".$e->getMessage();
    }
}

?>