<h1>Modifier un éditeur</h1>

<form method="POST" action="index.php?ressource=publisher&action=update" enctype="multipart/form-data">
    <p>
        <label for="name">Nom de l'éditeur</label>
        <p class="form-note">Ce champ est obligatoire.</p>
        <input type="text" id="name" name="name" value="<?php echo $_SESSION[ 'publisher' ][ 'name' ]; ?>">
        <?php if ( isset( $data[ 'errors' ][ 'name' ] ) ): ?>
            <div>
                <p>Erreur : <?php echo( $data[ 'errors' ][ 'name' ] ); ?></p>
            </div>
        <?php endif; ?>
    </p>
    <p>
        <label for="website">Site de l'éditeur</label>
        <input type="mail" id="website" name="website" value="<?php echo $_SESSION[ 'publisher' ][ 'website' ]; ?>">
        <?php if ( isset( $data[ 'errors' ][ 'website' ] ) ): ?>
            <div>
                <p>Erreur : <?php echo( $data[ 'errors' ][ 'website' ] ); ?></p>
            </div>
        <?php endif; ?>
    </p>
    <div>
        <p>
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
            <label for="logo">Logo de l'éditeur (format JPEG seulement, 5Mo maximum)</label>
            <input type="file" id="logo" name="logo">
            <?php if ( isset( $data[ 'errors' ][ 'logo' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'logo' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <p>
            <input type="checkbox" name="eraseLogo" value="on"> Supprimer le logo actuel
        </p>
    </div>
    <p>
        <label for="description">Description</label>
        <textarea id="description" name="description"><?php echo $_SESSION[ 'publisher' ][ 'description' ]; ?></textarea>
        <?php if ( isset( $data[ 'errors' ][ 'description' ] ) ): ?>
            <div>
                <p>Erreur : <?php echo( $data[ 'errors' ][ 'description' ] ); ?></p>
            </div>
        <?php endif; ?>
    </p>

    <input type="hidden" name="publisherId" value="<?php echo $_SESSION[ 'publisher' ][ 'id' ]; ?>">

    <p>
        <input type="submit" value="Modifier l'éditeur">
    </p>
</form>
