
    <h1>Liste des Auteurs</h1>

    <?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
        <a class="admin-link" href="index.php?ressource=author&action=create">Ajouter un auteur</a>
    <?php endif; ?>

    <?php if( $data[ 'authors' ] ): ?>
        <ul>
            <?php foreach( $data[ 'authors' ] as $author ): ?>
                <li><a class="content-link" href="index.php?ressource=author&action=view&id=<?php echo $author[ 'id' ]; ?>"><?php echo $author[ 'name' ] . ' ' . $author[ 'first_name' ]; ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><?php echo $data[ 'error' ]; ?></p>
    <?php endif; ?>
