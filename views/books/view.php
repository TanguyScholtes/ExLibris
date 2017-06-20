<?php if ( isset( $data[ 'book' ] ) ): ?>
    <div class="main-content">
        <?php $book = $data[ 'book' ]; ?>
        <h1><?php echo $book[ 'title' ]; ?></h1>

        <?php if ( isset( $_SESSION[ 'userId' ] ) ): ?>
            <a class="admin-link" href="index.php?ressource=book&action=edit&id=<?php echo $book[ 'id' ]; ?>">Modifier ce livre</a>
            <a class="admin-link" href="index.php?ressource=book&action=delete&id=<?php echo $book[ 'id' ]; ?>">Supprimer ce livre</a>
        <?php endif; ?>

        <div class="image-wrapper">
            <img class="content-image" src="<?php echo $book[ 'front_cover' ]; ?>" title="<?php echo $book[ 'title' ]; ?>">
        </div>

        <ul>
            <li><span>Titre :</span> <?php echo $book[ 'title' ]; ?></li>
            <li>
                <span>Auteur(s) :</span>
                <?php foreach ( $book[ 'authors' ] as $author ): ?>
                    <a class="content-link" href="index.php?ressource=author&action=view&id=<?php echo $author[ 'id' ]; ?>" ><?php echo $author[ 'first_name' ] . ' ' . $author[ 'name' ]; ?></a>
                <?php endforeach; ?>
            </li>
            <li>
                <span>Genre :</span>
                <a class="content-link" href="index.php?ressource=type&action=view&id=<?php echo $book[ 'type' ][ 'id' ]; ?>" ><?php echo $book[ 'type' ][ 'name' ]; ?></a>
            </li>
            <li>
                <span>Editeur :</span>
                <a class="content-link" href="index.php?ressource=publisher&action=view&id=<?php echo $book[ 'publisher' ][ 'id' ]; ?>" ><?php echo $book[ 'publisher' ][ 'name' ]; ?></a>
            </li>
            <li><span>Pages :</span> <?php echo $book[ 'npages' ]; ?></li>
            <li><span>ISBN :</span> <?php echo $book[ 'isbn' ]; ?></li>
            <li><span>Date de publication :</span> <?php echo $book[ 'datepub' ]; ?></li>
            <li><span>Langue :</span> <?php echo $book[ 'language' ][ 'full_name' ]; ?></li>
            <li><span>Emplacement :</span> <?php echo $book[ 'location' ][ 'name' ]; ?></li>
        </ul>

        <div>
            <h2>Résumé</h2>
            <p><?php echo $book[ 'summary' ]; ?></p>
        </div>

        <p>Dernière modification : <?php echo $book[ 'updated_at' ]; ?></p>
    </div>

    <div class="side-content">
        <h2>Du même auteur :</h2>
        <?php if( isset ( $book[ 'othersFromAuthor' ] ) ): ?>
            <ul>
                <?php foreach( $book[ 'othersFromAuthor' ] as $othersFromAuthor ): ?>
                    <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $othersFromAuthor[ 'id' ]; ?>"><?php echo $othersFromAuthor[ 'title' ]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Il n'y a pas d'autre livre du même auteur.</p>
        <?php endif; ?>
    </div>

    <div class="side-content">
        <h2>Du même éditeur :</h2>
        <?php if( $book[ 'othersFromPublisher' ] ): ?>
            <ul>
                <?php foreach( $book[ 'othersFromPublisher' ] as $othersFromPublisher ): ?>
                    <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $othersFromPublisher[ 'id' ]; ?>"><?php echo $othersFromPublisher[ 'title' ]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Il n'y a pas d'autre livre du même éditeur.</p>
        <?php endif; ?>
    </div>

    <div class="side-content">
        <h2>Du même genre :</h2>
        <?php if( $book[ 'othersFromType' ] ): ?>
            <ul>
                <?php foreach( $book[ 'othersFromType' ] as $othersFromType ): ?>
                    <li><a class="content-link" href="index.php?ressource=book&action=view&id=<?php echo $othersFromType[ 'id' ]; ?>"><?php echo $othersFromType[ 'title' ]; ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Il n'y a pas d'autre livre du même genre.</p>
        <?php endif; ?>
    </div>

<?php else: ?>
    <div class="main-content">
        <h1><?php echo $data[ 'page_title' ]; ?></h1>

        <p><?php echo $data[ 'error' ]; ?></p>
    </div>
<?php endif; ?>
