<h1>Ajouter un genre</h1>

<form method="POST" action="index.php?ressource=type&action=save">
    <p>
        <label for="name">Nom du genre</label>
        <p class="form-note">Ce champ est obligatoire.</p>
        <input type="text" id="name" name="name" value="<?php echo $_SESSION[ 'type' ][ 'name' ]; ?>">
        <?php if ( isset( $data[ 'errors' ][ 'name' ] ) ): ?>
            <div>
                <p>Erreur : <?php echo( $data[ 'errors' ][ 'name' ] ); ?></p>
            </div>
        <?php endif; ?>
    </p>

    <p>
        <label for="description">Description</label>
        <textarea id="description" name="description"><?php echo $_SESSION[ 'type' ][ 'description' ]; ?></textarea>
        <?php if ( isset( $data[ 'errors' ][ 'description' ] ) ): ?>
            <div>
                <p>Erreur : <?php echo( $data[ 'errors' ][ 'description' ] ); ?></p>
            </div>
        <?php endif; ?>
    </p>

    <p>
        <input type="submit" value="Créer le genre">
    </p>
</form>
