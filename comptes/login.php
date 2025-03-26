<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" href="../assets/css/btn.css">
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

       .conteneur {
            margin:auto;
            width: 90%;
            text-align: center;
            margin-top: 150px;    
        }
        .ca_section{
            max-width: 600px;
            border: solid black 1px;
            box-shadow: blue 2px 1px;
            margin:10px auto;
        }
      
        .formInput{
            margin:0 auto;
            margin-bottom: 20px;
            width: 300px;
            text-align: start;

            
            
        }
        
      input{
        min-width: 300px;
        padding: 5px;
        /* margin-bottom: 20px; */
        border: solid black 1px;
        border-radius: 8px;
        box-shadow:blue 2px 1px ;
        font-size: 18px;
      }
      .isRed{
    color: #e4002b;
}
.commentForm{
    font-size: 12px;
    color: #e4002b;
    margin:5px 0 0 0;
    padding: 0;
    
}
    </style>
</head>

<body>
    <div class="conteneur">
    <h1 id="titre"><span class="isRed">G</span>estion du parcking</h1>
        <div class="ca_section">
            <h1><span class="isRed">C</span>onnexion</h1>
   
            <form action="action.php" method="post" id="myForm">

                <div class="formInput">
                    <input type="text" name="email" id="email">
                    <p class="commentForm" id="emailErreur"></p>
                </div>
                <div class="formInput">
                    <input type="password" name="password" id="password">
                    <input type="hidden" name="auth">
                    <p class="commentForm" id="passwordErreur"></p>
                    
                </div>
                <div class="frmBtn">
                    <div class="btn-rouge" id="connexion">Connexion</div>
                    
                </div>
                <p class="commentForm" ><?php    
    if (isset($_SESSION['message'])) { 
        echo $_SESSION['message']; 
        unset($_SESSION['message']); 
    } 
     ?>
                <div class="formText">
                    <p>Mot de passe oublié ? <a href="">click-ici</a></p>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script rel="javascrypt" src="../config/functions.js"></script>
    <script>
        $(document).ready(function() {
            $('#connexion').click(function(e) {
                e.preventDefault();
                const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                var formHasErrors = false;
                if (!checkFormTexte("email", "", 1)) {
                    formHasErrors = true;
                } else if (!checkFormTexte("email", regexEmail, 1)) {
                    formHasErrors = true;
                }
                if (!checkFormTexte("password", "", 1)) {
                    formHasErrors = true;
                } 
                
                if (formHasErrors == false) {
                    $('#myForm').submit();
                }
            })
        })
    </script>
</body>

</html>