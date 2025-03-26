
<nav>
    <ul id="navigation">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="ajouter.php">Réserver</a></li>
        <li><a href="statistique.php">Statistiques</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li id="deconnexion"><a href="comptes/logout.php">Déconnexion</a></li>
        <?php else: ?>
        <li id="connexion"><a href="comptes/login.php">Connexion</a></li>
        <?php endif; ?>
    </ul>
</nav>