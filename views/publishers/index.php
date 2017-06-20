<h1>Liste des Éditeurs</h1>

<?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
    <a class="admin-link" href="index.php?ressource=publisher&action=create">Ajouter un éditeur</a>
<?php endif; ?>

<?php if( $data[ 'publishers' ] ): ?>
    <ul>
        <?php foreach( $data[ 'publishers' ] as $publisher ): ?>
            <li><a class="content-link" href="index.php?ressource=publisher&action=view&id=<?php echo $publisher[ 'id' ]; ?>"><?php echo $publisher[ 'name' ]; ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p><?php echo $data[ 'error' ]; ?></p>
<?php endif; ?>
