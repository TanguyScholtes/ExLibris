<nav class="main-navigation">
    <h2 class="main-navigation--title hidden">Navigation principale</h2>
    <a class="main-navigation--link" href="index.php">Livres</a>
    <a class="main-navigation--link" href="index.php?ressource=author&action=index">Auteurs</a>
    <a class="main-navigation--link" href="index.php?ressource=publisher&action=index">Éditeurs</a>
    <a class="main-navigation--link" href="index.php?ressource=type&action=index">Genres</a>
    <?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
        <a class="main-navigation--link" href="index.php?ressource=user&action=logout">Déconnexion</a>
    <?php else: ?>
        <a class="main-navigation--link" href="index.php?ressource=user&action=connect">Connexion</a>
    <?php endif; ?>
</nav>
