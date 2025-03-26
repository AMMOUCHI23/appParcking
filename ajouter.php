<?php
session_start();

ini_set('display_errors', 1);

include ("config/connexionDb.php");
// if (!isset($_SESSION['user'])) {
//     header('location:comptes/login.php');
// }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/formulaire.css">
    <link rel="stylesheet" href="assets/css/btn.css">
    <title>Réserver</title>
</head>

<body>
    <?php include "entete.php"  ?>
    <div id="conteneur">
        <div id="titre">
            <h1><span class="isRed">G</span>estion des places du parcking</h1>
        </div>

        <fieldset>
            <legend>Réserver une place</legend>
            <form action="traitement.php" method="POST" name="frm" id="myForm">

                <div class="frmLib">
                    <label for="nom" class="frmLib">Nom</label>
                </div>
                <div class="frmInput">
                    <input type="text" name="nom" id="nom" class="frmInput" placeholder="Nom">
                    <p class="commentForm" id="nomErreur"></p>
                </div>
                <div class="frmLib">
                    <label for="prenom" class="frmLib">Prénom</label>
                </div>
                <div class="frmInput">
                    <input type="text" name="prenom" id="prenom" class="frmInput" placeholder="Prénom">
                    <p class="commentForm" id="prenomErreur"></p>
                </div>
                
                <div class="frmLib">
                    <label for="mobile" class="frmLib">Mobile</label>
                </div>
                <div class="frmInput">
                    <input type="text" name="mobile" class="frmInput" id="mobile" placeholder="Mobile">
                    <p class="commentForm" id="mobileErreur"></p>
                </div>
                <div class="frmLib">
                    <label for="matricule" class="frmLib">Matricule</label>
                </div>
                <div class="frmInput">
                    <input type="text" name="matricule" id="matricule" class="frmInput" placeholder="Matricule de véhicule">
                    <p class="commentForm" id="matriculeErreur"></p>
                </div>
                <div class="frmLib">
                    <label for="place">Place</label>
                </div>
                <div class="frmInput">
                    <select name="place" id="place">
                        <option value="Choisi une place" selected>Choisi une place</option>
                        <?php 
                        connect_base_pdo();
                        $statut="libre";
                        $sql="SELECT* FROM places WHERE statut=:statut ORDER BY num_place" ;
                        $requete=$db->prepare($sql);
                        $requete->bindParam(":statut",$statut, PDO::PARAM_STR);
                        $requete->execute();
                        $donnees=$requete->fetchAll(PDO::FETCH_ASSOC);
                        
                        foreach ($donnees as $place) {
                            echo '<option value="' . $place['num_place'] . '">' . $place['num_place']. '</option>';
                       } ?>

                    </select>
                    <input type="hidden" name="envoyer">
                    <p class="commentForm" id="placeErreur"></p>
                </div>
                <!-- 
                 <div class="frmLib" >
                    <label for="DateEntre" class="frmLib">Date d'entrée</label>
                </div>
                <div class="frmInput">
                    <input type="datetime-local" name="DateEntre" class="frmInput" placeholder="Date d'entrée">
                    <p class="commentForm" id="dateErreur"></p>
                </div> -->
                <div class="frmBtn">
                    <div class="btn-rouge" id="ajouter">Ajouter</div>
                    <a href="index.php" class="btn-noir">Retour</a>
                </div>
            </form>
        </fieldset>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script rel="javascrypt" src="config/functions.js"></script>
    <script>
        $(document).ready(function() {
            $('#ajouter').click(function(e) {
                e.preventDefault();
                const regexNom = /^[a-zA-ZÀ-ÿ\- ]{2,50}$/;
                const regexMobile = /^0[67]\d{8}$/;
                const regexMatricule = /^[A-HJ-NP-TV-Z]{2}-\d{3}-[A-HJ-NP-TV-Z]{2}$/i;

                var formHasErrors = false;
                if (!checkFormTexte("nom", "", 1)) {
                    formHasErrors = true;
                } else if (!checkFormTexte("nom", regexNom, 1)) {
                    formHasErrors = true;
                }
                if (!checkFormTexte("prenom", "", 1)) {
                    formHasErrors = true;
                } else if (!checkFormTexte("prenom", regexNom, 1)) {
                    formHasErrors = true;
                }
                if (!checkFormTexte("mobile", "", 1)) {
                    formHasErrors = true;
                } else if (!checkFormTexte("mobile", regexMobile, 1)) {
                    formHasErrors = true;
                }

                if (!checkFormTexte("matricule", "", 1)) {
                    formHasErrors = true;
                } else if (!checkFormTexte("matricule", regexMatricule, 1)) {
                    formHasErrors = true;
                }

                if ($('#place').val() == "Choisi une place") {
                    $('#placeErreur').text('Merci de choisir une place');
                    formHasErrors = true;
                } else {
                    $('#placeErreur').text('');
                }

                if (formHasErrors == false) {
                    $('#myForm').submit();
                }
            })
        })
    </script>
</body>

</html>