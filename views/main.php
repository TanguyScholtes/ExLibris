<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="fr" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="fr" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="fr" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="fr" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $data[ 'page_title' ]; ?> - <?php echo SITE_TITLE; ?></title>
    <meta name="description" content="<?php echo( $data[ 'page_description' ] ); ?>">
    <meta name="author" content="<?php echo SITE_AUTHOR; ?>">

    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
</head>

<body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div id="top" class="banner">
        <a class="banner-link" href="index.php"><p class="site-title"><?php echo SITE_TITLE; ?></p></a>
    </div>

    <div class="navigation" id="main-menu">
        <?php include 'views/nav/_navigation.php'; ?>
    </div>

    <div class="main-wrapper">
        <main class="main-container">
            <div class="main-content">
                <!-- include view depending of processing step -->
                <?php include $data[ 'view' ]; ?>
            </div>
        </main>
    </div>

    <p id="back-to-top" class="back-to-top">
        <a class="back-to-top__link" href="#top">Retour en haut</a>
    </p>

    <footer class="footer">
        <p class="legal">
            Powered by <a class="source-link" href="<?php echo SITE_AUTHOR_CONTACT; ?>"><?php echo SITE_AUTHOR; ?></a>, <?php echo SITE_YEAR; ?>.
        </p>
        <p>Project repository available on <a class="source-link" href="https://github.com/TanguyScholtes/ExLibris">GitHub.</a></p>
        <p class="disclaimer">
            All brands, names, events, images and characters belong to their respective owners. No commercial use of any kind is made of this site. No copyright infringement of any kind intended.<br>
            This site is part of the 2017 cursus of the Programmation Web Coté Serveur course of the Haute Ecole de la Province de Liège, by teacher Dominique Vilain.
        </p>
    </footer>
</body>
</html>
