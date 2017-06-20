<?php if ( isset( $data[ 'type' ] ) ): ?>
    <?php $type = $data[ 'type' ]; ?>
    <h1><?php echo $type[ 'name' ]; ?></h1>

    <?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
        <a class="admin-link" href="index.php?ressource=type&action=edit&id=<?php echo $type[ 'id' ]; ?>">Modifier ce genre</a>
        <a class="admin-link" href="index.php?ressource=type&action=delete&id=<?php echo $type[ 'id' ]; ?>">Supprimer ce genre</a>
    <?php endif; ?>

    <?php if ( $type[ 'description' ] ): ?>
        <div>
            <h2>Description</h2>
            <p><?php echo $type[ 'description' ]; ?></p>
        </div>
    <?php endif; ?>


    <div>
        <h2>Livres du genre :</h2>
        <?php if( $type[ 'books' ] ): ?>
            <ul>
                <?php foreach( $type[ 'books' ] as $book ): ?>
                    <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $book[ 'id' ]; ?>"><?php echo $book[ 'title' ]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Il n'y a pas encore de livre de ce genre catalogué sur le site.</p>
        <?php endif; ?>
    </div>

    <div>
        <h2>Auteurs ayant publié dans ce genre :</h2>
        <?php if( $type[ 'authors' ] ): ?>
            <ul>
                <?php foreach( $type[ 'authors' ] as $author ): ?>
                    <li><a class="content-link" href="index.php?ressource=author&action=view&id=<?php echo $author[ 'id' ]; ?>"><?php echo $author[ 'name' ] . ' ' . $author[ 'first_name' ]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Il n'y a pas encore d'auteur ayant publié dans ce genre répertorié sur le site.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <h1><?php echo $data[ 'page_title' ]; ?></h1>

    <p><?php echo $data[ 'error' ]; ?></p>
<?php endif; ?>
