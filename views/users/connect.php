<div class="main-content">
    <h1>Se connecter</h1>

    <form method="POST" action="index.php?action=login&ressource=user">
        <p>
            <label for="email">Email</label>
            <input id="email" name="email" type="mail" placeholder="example@exlibris.be" value="<?php echo $_SESSION[ 'email' ]; ?>">
            <?php if ( isset( $data[ 'errors' ][ 'email' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'email' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <p>
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password">
            <?php if ( isset( $data[ 'errors' ][ 'password' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'password' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <p>
            <input type="submit" value="Connexion">
        </p>
    </form>
</div>
