<?php
function connect_base_pdo() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bdd = "parcking";

    global $db;

    try {
        $db = new PDO( 'mysql:host=' . $host . ';dbname=' . $bdd . ';charset=utf8', $user, $pass );
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        print($e->getMessage()) . "<br/>";
        die();
    }
    return($db);
}
?>