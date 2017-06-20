    <h1>Modifier le livre</h1>

    <form method="POST" action="index.php?ressource=book&action=update" enctype="multipart/form-data">
        <p>
            <label for="title">Titre du livre</label>
            <p class="form-note">Ce champ est obligatoire.</p>
            <input type="text" id="title" name="title" value="<?php echo $_SESSION[ 'book' ][ 'title' ]; ?>">
            <?php if ( isset( $data[ 'errors' ][ 'title' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'title' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <div>
            <p>
                <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                <label for="front_cover">Couverture du livre (format JPEG seulement, 5Mo maximum)</label>
                <input type="file" id="front_cover" name="front_cover" value="<?php echo $_SESSION[ 'book' ][ 'front_cover' ]; ?>">
                <?php if ( isset( $data[ 'errors' ][ 'front_cover' ] ) ): ?>
                    <div>
                        <p>Erreur : <?php echo( $data[ 'errors' ][ 'front_cover' ] ); ?></p>
                    </div>
                <?php endif; ?>
            </p>
            <p>
                <input type="checkbox" name="eraseCover" value="on"> Supprimer la couverture actuelle
            </p>
        </div>
        <p>
            <label for="summary">Résumé</label>
            <textarea id="summary" name="summary"><?php echo $_SESSION[ 'book' ][ 'summary' ]; ?></textarea>
            <?php if ( isset( $data[ 'errors' ][ 'summary' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'summary' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <p>
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" value="<?php echo $_SESSION[ 'book' ][ 'isbn' ]; ?>">
            <?php if ( isset( $data[ 'errors' ][ 'isbn' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'isbn' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <p>
            <label for="npages">Nombre de pages</label>
            <input type="number" min="1" id="npages" name="npages" value="<?php echo $_SESSION[ 'book' ][ 'npages' ]; ?>">
            <?php if ( isset( $data[ 'errors' ][ 'npages' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'npages' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <div>
            <p>
                <label>Date de publication</label>
            </p>
            <p>
                <label for="datepub-day">Jour</label>
                <input type="number" max="31" min="1" id="datepub-day" name="datepub-day" placeholder="JJ" value="<?php echo $_SESSION[ 'book' ][ 'datepub-day' ]; ?>">
                <label for="datepub-month">Mois</label>
                <input type="number" max="12" min="1" id="datepub-month" name="datepub-month" placeholder="MM" value="<?php echo $_SESSION[ 'book' ][ 'datepub-month' ]; ?>">
                <label for="datepub-year">Année</label>
                <input type="number" id="datepub-year" name="datepub-year" placeholder="YYYY" value="<?php echo $_SESSION[ 'book' ][ 'datepub-year' ]; ?>">
            <p>
                <?php if ( isset( $data[ 'errors' ][ 'datepub' ] ) ): ?>
                    <div>
                        <p>Erreur : <?php echo( $data[ 'errors' ][ 'datepub' ] ); ?></p>
                    </div>
                <?php endif; ?>
        </div>
        <p>
            <label for="language_id">Langue</label>
            <select id="language_id" name="language_id">
                <option value=""> </option>
                <?php foreach ( $data[ 'languages' ] as $language ): ?>
                    <option value="<?php echo $language[ 'id' ]; ?>"
                        <?php if( $_SESSION[ 'book' ][ 'language_id' ] == $language[ 'id' ] ): ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo $language[ 'full_name' ]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ( isset( $data[ 'errors' ][ 'language' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'language' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <p>
            <label for="location_id">Emplacement</label>
            <select id="location_id" name="location_id">
                <option value=""> </option>
                <?php foreach ( $data[ 'locations' ] as $location ): ?>
                    <option value="<?php echo $location[ 'id' ]; ?>"
                        <?php if( $_SESSION[ 'book' ][ 'location_id' ] == $location[ 'id' ] ): ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo $location[ 'name' ]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ( isset( $data[ 'errors' ][ 'location' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'location' ] ); ?></p>
                </div>
            <?php endif; ?>
        </p>
        <div>
            <label for="editor_id">Editeur</label>
            <p>Vous ne pouvez que choisir un éditeur dans la liste déjà existante. Si l'éditeur souhaité n'y figure pas, pensez à <a class="content-link" href="index.php?ressource=publisher&action=create">l'ajouter à notre liste</a>.</p>
            <select id="editor_id" name="editor_id">
                <option value=""> </option>
                <?php foreach ( $data[ 'publishers' ] as $publisher ): ?>
                    <option value="<?php echo $publisher[ 'id' ]; ?>"
                        <?php if( $_SESSION[ 'book' ][ 'editor_id' ] == $publisher[ 'id' ] ): ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo $publisher[ 'name' ]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ( isset( $data[ 'errors' ][ 'publisher' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'publisher' ] ); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <div>
            <label for="genre_id">Genre</label>
            <p>Vous ne pouvez que choisir un genre dans la liste déjà existante. Si le genre souhaité n'y figure pas, pensez à <a class="content-link" href="index.php?ressource=type&action=create">l'ajouter à notre liste</a>.</p>
            <select id="genre_id" name="genre_id">
                <option value=""> </option>
                <?php foreach ( $data[ 'types' ] as $type ): ?>
                    <option value="<?php echo $type[ 'id' ]; ?>"
                        <?php if( $_SESSION[ 'book' ][ 'genre_id' ] == $type[ 'id' ] ): ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo $type[ 'name' ]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ( isset( $data[ 'errors' ][ 'type' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'type' ] ); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <div>
            <label for="authors_id">Auteur</label>
            <p>Vous ne pouvez que choisir qu'un ou plusieurs auteurs dans la liste déjà existante. Si le ou les auteurs souhaités n'y figurent pas, pensez à <a class="content-link" href="index.php?ressource=author&action=create">les ajouter à notre liste</a>.</p>
            <select multiple id="authors_id" name="authors_id[]">
                <option value=""> </option>
                <?php foreach ( $data[ 'authors' ] as $author ): ?>
                    <option value="<?php echo $author[ 'id' ]; ?>"
                        <?php if( in_array( $author[ 'id' ], $_SESSION[ 'book' ][ 'authors' ] ) ): ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo $author[ 'name' ] . ' ' . $author[ 'first_name' ]; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ( isset( $data[ 'errors' ][ 'author' ] ) ): ?>
                <div>
                    <p>Erreur : <?php echo( $data[ 'errors' ][ 'author' ] ); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <input type="hidden" name="bookId" value="<?php echo $_SESSION[ 'book' ][ 'id' ]; ?>">

        <p>
            <input type="submit" value="Modifier le livre">
        </p>
    </form>
