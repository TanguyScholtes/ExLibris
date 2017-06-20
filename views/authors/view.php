    <?php if ( isset( $data[ 'author' ] ) ): ?>
        <?php $author = $data[ 'author' ]; ?>
        <h1><?php echo $author[ 'first_name' ] . ' ' . $author[ 'name' ]; ?></h1>

        <?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
            <a class="admin-link" href="index.php?ressource=author&action=edit&id=<?php echo $author[ 'id' ]; ?>">Modifier cet auteur</a>
            <a class="admin-link" href="index.php?ressource=author&action=delete&id=<?php echo $author[ 'id' ]; ?>">Supprimer cet auteur</a>
        <?php endif; ?>

        <div class="image-wrapper">
            <img class="content-image" src="<?php echo $author['photo']; ?>" title="<?php echo $author[ 'first_name' ] . ' ' . $author[ 'name' ]; ?>">
        </div>

        <?php if ( $author[ 'datebirth' ] || $author[ 'datedeath' ] ): ?>
            <ul>
                <li><span>Date de naissance :</span> <?php echo $author[ 'datebirth' ]; ?></li>
                <li><span>Date de déces :</span> <?php echo $author[ 'datedeath' ]; ?></li>
            </ul>
        <?php endif; ?>
        <div>
            <h2>Biographie</h2>
            <p><?php echo $author[ 'bio' ]; ?></p>
        </div>

        <div>
            <h2>Livres de l'auteur :</h2>
            <?php if( $author[ 'books' ] ): ?>
                <ul>
                    <?php foreach( $author[ 'books' ] as $book ): ?>
                        <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $book[ 'id' ]; ?>"><?php echo $book[ 'title' ]; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Cet auteur n'a pas encore de livre catalogué sur le site.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <h1><?php echo $data[ 'page_title' ]; ?></h1>

        <p><?php echo $data[ 'error' ]; ?></p>
    <?php endif; ?>
