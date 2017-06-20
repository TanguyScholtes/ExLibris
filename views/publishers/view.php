<?php if ( isset( $data[ 'publisher' ] ) ): ?>
    <?php $publisher = $data[ 'publisher' ]; ?>
    <h1><?php echo $publisher[ 'name' ]; ?></h1>

    <?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
        <a class="admin-link" href="index.php?ressource=publisher&action=edit&id=<?php echo $publisher[ 'id' ]; ?>">Modifier cet éditeur</a>
        <a class="admin-link" href="index.php?ressource=publisher&action=delete&id=<?php echo $publisher[ 'id' ]; ?>">Supprimer cet éditeur</a>
    <?php endif; ?>

    <div class="image-wrapper">
        <img class="content-image" src="<?php echo $publisher[ 'logo' ]; ?>" title="<?php echo $publisher[ 'name' ]; ?>">
    </div>

    <?php if ( $publisher[ 'website' ] ): ?>
        <p><span>Site web :</span> <a class="content-link" href="<?php echo $publisher[ 'website' ]; ?>">Visiter le site web de <?php echo $publisher[ 'name' ]; ?></a></p>
    <?php endif; ?>

    <?php if ( $publisher[ 'description' ] ): ?>
        <div>
            <h2>Description</h2>
            <p><?php echo $publisher[ 'description' ]; ?></p>
        </div>
    <?php endif; ?>


    <div>
        <h2>Livres publiés par l'éditeur :</h2>
        <?php if( $publisher[ 'books' ] ): ?>
            <ul>
                <?php foreach( $publisher[ 'books' ] as $book ): ?>
                    <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $book[ 'id' ]; ?>"><?php echo $book[ 'title' ]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Cet éditeur n'a pas encore de livre catalogué sur le site.</p>
        <?php endif; ?>
    </div>

    <div>
        <h2>Auteurs publiés par l'éditeur :</h2>
        <?php if( $publisher[ 'authors' ] ): ?>
            <ul>
                <?php foreach( $publisher[ 'authors' ] as $author ): ?>
                    <li><a class="content-link" href="index.php?ressource=author&action=view&id=<?php echo $author[ 'id' ]; ?>"><?php echo $author[ 'name' ] . ' ' . $author[ 'first_name' ]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Cet éditeur n'a pas encore d'auteur publié répertorié sur le site.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <h1><?php echo $data[ 'page_title' ]; ?></h1>

    <p><?php echo $data[ 'error' ]; ?></p>
<?php endif; ?>
