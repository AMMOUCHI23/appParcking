<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:comptes/login.php');
}
include ("config/connexionDb.php");

connect_base_pdo();

// Requête pour le chiffre d'affaires du jour
$sqlJour = "SELECT SUM(montant) AS recette_jour 
FROM paiements 
WHERE DATE(date_paiement) = CURDATE()";
$requeteJour = $db->prepare($sqlJour);
$requeteJour->execute();
$resultJour = $requeteJour->fetch(PDO::FETCH_ASSOC);
$recetteJour = $resultJour['recette_jour'] ?? 0;

// Requête pour le chiffre d'affaires du mois
$sqlMois = "SELECT SUM(montant) AS recette_mois 
FROM paiements 
WHERE YEAR(date_paiement) = YEAR(CURDATE()) 
  AND MONTH(date_paiement) = MONTH(CURDATE())";
$requeteMois = $db->prepare($sqlMois);
$requeteMois->execute();
$resultMois = $requeteMois->fetch(PDO::FETCH_ASSOC);
$recetteMois = $resultMois['recette_mois'] ?? 0;

// Requête pour le chiffre d'affaires de l'année
$sqlAnnee = "SELECT SUM(montant) AS recette_annee 
 FROM paiements
 WHERE YEAR(date_paiement) = YEAR(CURDATE())";
$requeteAnnee = $db->prepare($sqlAnnee);
$requeteAnnee->execute();
$resultAnnee = $requeteAnnee->fetch(PDO::FETCH_ASSOC);
$recetteAnnee = $resultAnnee['recette_annee'] ?? 0;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staistiques</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/statistiques.css">
    <link rel="stylesheet" href="assets/css/btn.css">
</head>
<body>
<?php include "entete.php"  ?>
<h1 id="titre"><span class="isRed">C</span>hiffre d'Affaires</h1>
<div class="conteneur">
<section>
        <div class="ca-section">
            <h2>Chiffre d'affaires du jour</h2>
            <p class="ca-value"><?php echo number_format($recetteJour,2)  ?> €</p>
        </div>
    
        <div class="ca-section">
            <h2>Chiffre d'affaires du mois</h2>
            <p class="ca-value"><?php echo number_format($recetteMois,2)  ?> €</p>
        </div>
    
        <div class="ca-section">
            <h2>Chiffre d'affaires de l'année</h2>
            <p class="ca-value"><?php echo number_format($recetteAnnee,2) ?> €</p>
        </div>

        <div class="frmBtn">
                    <a href="index.php" class="btn-noir">Retour</a>
                </div>
    </section>
</div>
    
    
</body>
</html>