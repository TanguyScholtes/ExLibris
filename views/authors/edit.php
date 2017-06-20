    <h1>Modifier un auteur</h1>

    <form method="POST" action="index.php?ressource=author&action=update" enctype="multipart/form-data">
        <p>
            <label for="name">Nom de l'auteur</label>
            <p class="form-note">Ce champ est obligatoire.</p>
            <input type="text" id="name" name="name" value="<?php echo $_SESSION[ 'author' ][ 'name' ]; ?>">
            <?php if ( isset( $data[ 'errors' ][ 'name' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'name' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <p>
            <label for="first_name">Prénom de l'auteur</label>
            <p class="form-note">Ce champ est obligatoire.</p>
            <input type="text" id="first_name" name="first_name" value="<?php echo $_SESSION[ 'author' ][ 'first_name' ]; ?>">
            <?php if ( isset( $data[ 'errors' ][ 'first_name' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'first_name' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <div>
            <p>
                <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                <label for="photo">Photo (format JPEG seulement, 5Mo maximum)</label>
                <input type="file" id="photo" name="photo">
                <?php if ( isset( $data[ 'errors' ][ 'photo' ] ) ): ?>
                    <div>
                        <p>Erreur : <?php echo( $data[ 'errors' ][ 'photo' ] ); ?></p>
                    </div>
                <?php endif; ?>
            </p>
            <p>
                <input type="checkbox" name="erasePhoto" value="on"> Supprimer la photo actuelle
            </p>
        </div>
        <div>
            <p>
                <label>Date de naissance</label>
            </p>
            <p>
                <label for="datebirth-day">Jour</label>
                <input type="number" max="31" min="1" id="datebirth-day" name="datebirth-day" placeholder="JJ" value="<?php echo $_SESSION[ 'author' ][ 'datebirth-day' ]; ?>">
                <label for="datebirth-month">Mois</label>
                <input type="number" max="12" min="1" id="datebirth-month" name="datebirth-month" placeholder="MM" value="<?php echo $_SESSION[ 'author' ][ 'datebirth-month' ]; ?>">
                <label for="datebirth-year">Année</label>
                <input type="number" id="datebirth-year" name="datebirth-year" placeholder="YYYY" value="<?php echo $_SESSION[ 'author' ][ 'datebirth-year' ]; ?>">
            </p>
                <?php if ( isset( $data[ 'errors' ][ 'datebirth' ] ) ): ?>
                    <div>
                        <p>Erreur : <?php echo( $data[ 'errors' ][ 'datebirth' ] ); ?></p>
                    </div>
                <?php endif; ?>
        </div>
        <div>
            <p>
                <label>Date de déces</label>
            </p>
            <p>
                <label for="datedeath-day">Jour</label>
                <input type="number" max="31" min="1" id="datedeath-day" name="datedeath-day" placeholder="JJ" value="<?php echo $_SESSION[ 'author' ][ 'datedeath-day' ]; ?>">
                <label for="datedeath-month">Mois</label>
                <input type="number" max="12" min="1" id="datedeath-month" name="datedeath-month" placeholder="MM" value="<?php echo $_SESSION[ 'author' ][ 'datedeath-month' ]; ?>">
                <label for="datedeath-year">Année</label>
                <input type="number" id="datedeath-year" name="datedeath-year" placeholder="YYYY" value="<?php echo $_SESSION[ 'author' ][ 'datedeath-year' ]; ?>">
            </p>
                <?php if ( isset( $data[ 'errors' ][ 'datedeath' ] ) ): ?>
                    <div>
                        <p>Erreur : <?php echo( $data[ 'errors' ][ 'datedeath' ] ); ?></p>
                    </div>
                <?php endif; ?>
        </div>
        <p>
            <label for="bio">Biographie</label>
            <textarea id="bio" name="bio"><?php echo $_SESSION[ 'author' ][ 'bio' ]; ?></textarea>
            <?php if ( isset( $data[ 'errors' ][ 'bio' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'bio' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>

        <input type="hidden" name="authorId" value="<?php echo $_SESSION[ 'author' ][ 'id' ]; ?>">

        <p>
            <input type="submit" value="Modifier l'auteur">
        </p>
    </form>
