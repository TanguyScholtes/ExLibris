    <h1>Liste des Livres</h1>

    <?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
        <a class="admin-link" href="index.php?ressource=book&action=create">Ajouter un livre</a>
    <?php endif; ?>

    <?php if( $data[ 'books' ] ): ?>
        <ul>
            <?php foreach( $data[ 'books' ] as $book ): ?>
                <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $book[ 'id' ]; ?>"><?php echo $book[ 'title' ]; ?></a></li>
            <?php endforeach; ?>
        </ul>

        <div class="side-content">
            <h2>Derniers ajouts</h2>
            <ol>
                <?php foreach( $data[ 'lastBooks' ] as $book ): ?>
                    <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $book[ 'id' ]; ?>"><?php echo $book[ 'title' ]; ?></a></li>
                <?php endforeach; ?>
            </ol>
        </div>
    <?php else: ?>
        <p><?php echo $data[ 'error' ]; ?></p>
    <?php endif; ?>
