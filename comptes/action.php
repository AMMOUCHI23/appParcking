<?php
session_start();
ini_set('display_errors', 1);
include("../config/connexionDb.php");
connect_base_pdo();
if (isset($_POST["auth"])) {
    try {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT password , nom FROM utilisateurs WHERE email=:email";
        $requete = $db->prepare($sql);
        $requete->bindParam(':email',$email,PDO::PARAM_STR);
        $requete->execute();
        $result = $requete->fetch(PDO::FETCH_ASSOC);
        $passwordBdd = $result['password'];
        $nom=$result['nom'];
        if (password_verify($password, $passwordBdd)) {
            $_SESSION['user'] = $nom;
            header('location:../index.php');
        } else {
            $_SESSION['message'] = "Email ou mot de passe incorrect";
            header('location:login.php');
        }
    } catch (Exception $e) {
        echo "Erreur " . $e->getMessage();
    }
} else {
    $_SESSION['message'] = "Email ou mot de passe incorrect";
    header('location:login.php');
}
