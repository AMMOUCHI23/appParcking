<?php
session_start();
include "config/connexionDb.php";
if (!isset($_SESSION['user'])) {
    header('location:comptes/login.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Parcking</title>
</head>

<body>
    <?php include "entete.php"  ?>
    <h1 id="titre"><span class="isRed">G</span>estion du parcking</h1>
    <table>
        <thead>
        <tr>
            <th data-sort="int">Place</th>
            <th data-sort="string">Matricule</th>
            <th data-sort="string">Nom</th>
            <th data-sort="string">Prénom</th>
            <th>Téléphone</th>
            <th data-sort="string">Date d'entrée</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        try {
            connect_base_pdo();
            $sql = "SELECT * FROM reservations WHERE date_sortie IS NULL ";
            $requete = $db->prepare($sql);
            // $requete->bindParam(":num-place",1);
            $requete->execute();
            $donnees = $requete->fetchAll(PDO::FETCH_OBJ);

            foreach ($donnees as $ligne) {
                echo "<tr>";
                echo '<td>' . $ligne->num_place . '</td>';
                echo  '<td>' . $ligne->matricule . '</td>';
                echo ' <td>' . $ligne->nom . '</td>';
                echo '<td>' . $ligne->prenom . '</td>';
                echo '<td>' . $ligne->mobile . '</td>';
                echo '<td>' . $ligne->date_entre . '</td>';
                echo "<td  ><a class='action' href='paiement.php?t=" . $ligne->num_place . " &i=" . $ligne->id . "'>Paiement</a></td>";
                echo '</tr>';
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
        ?>
        </tbody>

    </table>


    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/stupid-table-plugin@1.1.3/stupidtable.min.js"></script>

    <script>
        $(document).ready(function() {
           $("table").stupidtable();

        })
    </script>
</body>

</html>