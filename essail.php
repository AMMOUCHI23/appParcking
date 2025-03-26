<?php
ini_set('display_errors', 1);
include ("config/connexionDb.php");
// $password= password_hash("Maformation2023", PASSWORD_DEFAULT);
// echo $password;

try {
    connect_base_pdo();
    // Préparer la requête d'insertion
    $sql="INSERT INTO `places`(`num_place`) VALUES (:num_place)";
    $requete=$db->prepare($sql);
    // Boucle pour insérer 75 places
    for ($i = 1; $i <= 75; $i++) {
        $num_place = $i;

        // Exécuter l'insertion avec les valeurs
        $requete->execute([
            ':num_place' => $num_place,
        ]);

        echo "Place $num_place insérée avec succès.<br>";
    }

    echo "Toutes les places ont été insérées avec succès !";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}