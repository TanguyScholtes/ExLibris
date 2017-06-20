<h1>Liste des Genres</h1>

<?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
    <a class="admin-link" href="index.php?ressource=type&action=create">Ajouter un genre</a>
<?php endif; ?>

<?php if( $data[ 'types' ] ): ?>
    <ul>
        <?php foreach( $data[ 'types' ] as $type ): ?>
            <li><a class="content-link" href="index.php?ressource=type&action=view&id=<?php echo $type[ 'id' ]; ?>"><?php echo $type[ 'name' ]; ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p><?php echo $data[ 'error' ]; ?></p>
<?php endif; ?>
