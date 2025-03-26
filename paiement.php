<?php
session_start();
ini_set('display_errors', 1);
if (!isset($_SESSION['user'])) {
    header('location:comptes/login.php');
}
date_default_timezone_set('Europe/Paris');
include ("config/connexionDb.php");
include ("config/fonctions.php");
if (isset($_GET['t']) && isset($_GET['i'])) {
    $num_place=$_GET['t'];
    $reservationId=$_GET['i'];
    connect_base_pdo();
    $sql="SELECT date_entre from reservations WHERE id=:id";
    $requete=$db->prepare($sql);
    $requete->bindParam(':id',$reservationId, PDO::PARAM_INT );
    $requete->execute();
    $result=$requete->fetch(PDO::FETCH_ASSOC);
    $dateEntree=$result["date_entre"];
    $dateSortie=date("Y/m/d  H:i:s");
    
}else {
    header('location : index.php');
}

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
            <legend>Paiement</legend>
            <form action="traitement.php" method="POST" name="frm" id="myForm">

                <div class="frmLib"> 
                    <label for="montant" class="frmLib">Montant</label>
                </div>
                <div class="frmInput">
                <?php   
                    echo "<input type='text' name='montant' id='montant'  class='frmInput' value='".calculerFacturationParking($dateEntree, $dateSortie).' euros'."'  >";
                    
                    ?>
                    
                </div>
                <div class="frmLib">
                    <label for="prenom" class="frmLib">Mode_paiement</label>
                </div>
                <div class="frmInput">
                    <select name="mode_paiement" id="mode_paiement">
                        <option value="choisi le mode de paiement" selected>Choisi le mode de paiement</option>
                        <option value="carte bancaire">Carte bancaire</option>
                        <option value="mobile" >Mobile</option>
                        <option value="espece" >Espèce</option>
                    </select>
                    <input type="hidden" name="num_place" value="<?php echo $num_place ?>" >
                    <input type="hidden" name="reservation_id" value="<?php echo $reservationId ?>" >
                    <input type="hidden" name="payer">
                    <p class="commentForm" id="paiementErreur"></p>
                </div>
                
                <div class="frmBtn">
                    <div class="btn-rouge" id="payer">Payer</div>
                    <a href="index.php" class="btn-noir">Retour</a>
                </div>
            </form>
        </fieldset>
    </div>


    <script
        src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8="
        crossorigin="anonymous"></script>
    <script rel="javascrypt" src="config/functions.js"></script>
    <script>
        $(document).ready(function() {
            $('#payer').click(function(e) {
                e.preventDefault();
                var formHasErrors = false;
                
                if ($('#mode_paiement').val() == "choisi le mode de paiement") {
                    $('#paiementErreur').text('Merci de choisir le mode de paiement');
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