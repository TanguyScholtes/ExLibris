<?php

namespace Controllers;
use Models\Publisher as PublisherModel;
use Models\Book as BookModel;
use Models\Author as AuthorModel;

class Publisher extends Controller {

    protected $model = null;

    function __construct () {
        $this -> model = new PublisherModel();
    }

    public function index () {
        $view = 'views/publishers/index.php';
        $page_title = 'Liste des Éditeurs';
        $page_description = 'Liste des éditeurs présents sur Ex Libris.';
        $publishers = $this -> model -> getAllPublishers();
        if ( $publishers ) {
                return compact( 'view', 'page_title', 'page_description', 'publishers' );
        } else {
            $error = 'Il n\'y a aucun éditeur à afficher pour l\'instant.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }
    }

    public function view () {
        $view = 'views/publishers/view.php';
        $publisherId = 0;
        if ( isset( $_REQUEST[ 'id' ] ) && ctype_digit( $_REQUEST[ 'id' ] ) ) {
            $publisherId = $_REQUEST[ 'id' ];
        } else {
            $error = 'Identifiant invalide.';
            $page_title = 'Erreur';
            $page_description = 'Erreur - Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }

        $publisher = $this -> model -> getPublisher( $publisherId );
        if ( $publisher ) {
            $this -> model = new BookModel();
            $publisher[ 'books' ] = $this -> model -> getBooksByPublisherId( $publisherId );
            $this -> model = new AuthorModel();
            $publisher[ 'authors' ] = $this -> model -> getAuthorsByPublisherId( $publisherId );

            $page_title = $publisher[ 'name' ];
            $page_description = 'Fiche de l\'éditeur ' . $publisher[ 'name' ] . ' sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'publisher' );
        } else {
            $error = 'Cet éditeur n\'existe pas.';
            $page_title = 'Erreur';
            $page_description = 'Erreur - Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }
    }

    public function create () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            $_SESSION[ 'publisher' ] = null;
            $view = 'views/publishers/create.php';
            $page_title = 'Ajouter un éditeur';
            $page_description = 'Ajouter un éditeur sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description' );
        }
    }

    public function save () {
        $view = 'views/publishers/create.php';
        $page_title = 'Ajouter un éditeur';
        $page_description = 'Ajouter un éditeur sur Ex Libris.';

        $_SESSION[ 'publisher' ][ 'name' ] = $_POST[ 'name' ];
        $_SESSION[ 'publisher' ][ 'logo' ] = null;
        $_SESSION[ 'publisher' ][ 'website' ] = $_POST[ 'website' ];
        $_SESSION[ 'publisher' ][ 'description' ] = $_POST[ 'description' ];

        if( isset( $_POST[ 'name' ] ) ) {
            //check photo
            if ( !is_null( $_FILES[ 'logo' ] ) && !empty( $_POST[ 'logo' ] ) ) {
                //check file type
                $allowedTypes = [ 'image/jpg', 'image/jpeg' ];
                if ( isset( $_FILES[ 'logo' ][ 'type' ] ) && in_array( $_FILES[ 'logo' ][ 'type' ], $allowedTypes ) ) {
                    //file deplacing to keep permanent track
                    $typeParts = explode( '.', $_FILES[ 'logo' ][ 'name' ] );
                    $type = $typeParts[ count( $typeParts ) - 1 ];
                    $filename = 'f' . time() . rand( 1000, 9999 ) . '.' . $type;
                    $destination = './files/publishers/' . $filename; //must contain file name and type

                    //--- IMAGE UPLOAD AND HANDLING (using 'GD')
                    list( $width, $height ) = getimagesize( $_FILES[ 'logo' ][ 'tmp_name' ] );
                    $redim = imagecreatetruecolor( 300, 300 ); //POINTS TOWARD RESSOURCE, NOT A PATH
                    $image = imagecreatefromjpeg( $_FILES[ 'logo' ][ 'tmp_name' ] ); //POINTS TOWARD RESSOURCE, NOT A PATH
                    imagecopyresampled( $redim, $image, 0, 0, 0, 0, 300, 300, $width, $height);
                    imagejpeg( $redim, $destination, 100 );

                    $_SESSION[ 'publisher' ][ 'logo' ] = $destination;
                } else {
                    $errors[ 'logo' ] = 'Type de fichier non-valide. Seuls les images JPEG sont autorisées.';
                }
            }

            //check website URL
            if ( isset( $_POST[ 'website' ] ) && is_string( $_POST[ 'website' ] ) && !empty( $_POST[ 'website' ] ) ) {
                $url = filter_var( $_POST[ 'website' ], FILTER_SANITIZE_URL );
                if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
                    $_SESSION[ 'publisher' ][ 'website' ] = $url;
                } else {
                    $errors[ 'website' ] = 'L\'URL fournie n\'est pas valide.';
                }
            }

            //check description
            if ( isset( $_POST[ 'description' ] ) && !is_string( $_POST[ 'description' ] ) && !empty( $_POST[ 'description' ] ) ) {
                $errors[ 'description' ] = 'Ce texte n\'est pas valide.';
            }

            if ( isset( $errors ) ) {
                return compact( 'view', 'page_title', 'page_description', 'errors' );
            } else {
                //create in DB
                $publisher = $this -> model -> save( $_SESSION[ 'publisher' ][ 'name' ], $_SESSION[ 'publisher' ][ 'website' ], $_SESSION[ 'publisher' ][ 'logo' ], $_SESSION[ 'publisher' ][ 'description' ] );

                //redirect to publisher index
                header( 'Location: ./index.php?ressource=publisher&action=index' );
                die();
            }
        } else {
            $errors[ 'name' ] = 'Votre éditeur doit avoir au moins un nom valide.';
        }
    }

    public function delete () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            if ( isset( $_GET[ 'id' ] ) ) {
                $publisherId = intval( $_GET[ 'id' ] );
                $publisher = $this -> model -> getPublisher( $publisherId );
                if ( $publisher ) {
                    //delete publisher
                    $this -> model -> deletePublisher( $publisherId );

                    header( 'Location: ./index.php?ressource=publisher&action=index' );
                    die();
                } else {
                    //publisher doesn't exist
                }
            } else {
                //invalid ID
            }
        }
    }

    public function edit () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            if ( isset( $_GET[ 'id' ] ) ) {
                $publisherId = intval( $_GET[ 'id' ] );
                $publisher = $this -> model -> getPublisher( $publisherId );
                if ( $publisher ) {
                    $_SESSION[ 'publisher' ] = $publisher;

                    $view = 'views/publishers/edit.php';
                    $page_title = 'Modifier un éditeur';
                    $page_description = 'Modifier un éditeur sur Ex Libris.';
                    return compact( 'view', 'page_title', 'page_description' );
                } else {
                    //publisher doesn't exist
                }
            } else {
                //invalid ID
            }
        }
    }

    public function update () {
        $view = 'views/publishers/edit.php';
        $page_title = 'Modifier un éditeur';
        $page_description = 'Modifier un éditeur sur Ex Libris.';

        if ( isset( $_POST[ 'publisherId' ] ) ) {
            $publisherId = intval( $_POST[ 'publisherId' ] );
            $publisher = $this -> model -> getPublisher( $publisherId );
            if ( $publisher ) {
                $_SESSION[ 'publisher' ] = $publisher;

                if( isset( $_POST[ 'name' ] ) ) {
                    $_SESSION[ 'publisher' ][ 'name' ] = $_POST[ 'name' ];

                    //check photo
                    if ( isset( $_FILES[ 'logo' ] ) && !empty( $_FILES[ 'logo' ] ) && !empty( $_FILES[ 'logo' ][ 'type' ] ) ) {
                        //check file type
                        $allowedTypes = [ 'image/jpg', 'image/jpeg' ];
                        if ( isset( $_FILES[ 'logo' ][ 'type' ] )  && in_array( $_FILES[ 'logo' ][ 'type' ], $allowedTypes ) ) {
                            //file deplacing to keep permanent track
                            $typeParts = explode( '.', $_FILES[ 'logo' ][ 'name' ] );
                            $type = $typeParts[ count( $typeParts ) - 1 ];
                            $filename = 'f' . time() . rand( 1000, 9999 ) . '.' . $type;
                            $destination = './files/publishers/' . $filename; //must contain file name and type

                            //--- IMAGE UPLOAD AND HANDLING (using 'GD')
                            list( $width, $height ) = getimagesize( $_FILES[ 'logo' ][ 'tmp_name' ] );
                            $redim = imagecreatetruecolor( 300, 300 ); //POINTS TOWARD RESSOURCE, NOT A PATH
                            $image = imagecreatefromjpeg( $_FILES[ 'logo' ][ 'tmp_name' ] ); //POINTS TOWARD RESSOURCE, NOT A PATH
                            imagecopyresampled( $redim, $image, 0, 0, 0, 0, 300, 300, $width, $height);
                            imagejpeg( $redim, $destination, 100 );

                            unlink( $_SESSION[ 'publisher' ][ 'logo' ] );
                            $_SESSION[ 'publisher' ][ 'logo' ] = $destination;
                        } else {
                            $errors[ 'logo' ] = 'Type de fichier non-valide. Seuls les images JPEG sont autorisées.';
                        }
                    }

                    //check if photo is to be erased
                    if ( isset( $_POST[ 'eraseLogo' ] ) && $_POST[ 'eraseLogo' ] == "on" ) {
                        unlink( $_SESSION[ 'publisher' ][ 'logo' ] );
                        $_SESSION[ 'publisher' ][ 'logo' ] = null;
                    }

                    //check website URL
                    if ( isset( $_POST[ 'website' ] ) && is_string( $_POST[ 'website' ] ) && !empty( $_POST[ 'website' ] ) ) {
                        $url = filter_var( $_POST[ 'website' ], FILTER_SANITIZE_URL );
                        if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
                            $_SESSION[ 'publisher' ][ 'website' ] = $url;
                        } else {
                            $errors[ 'website' ] = 'L\'URL fournie n\'est pas valide.';
                        }
                    }

                    //check description
                    if ( isset( $_POST[ 'description' ] ) && !is_string( $_POST[ 'description' ] ) && !empty( $_POST[ 'description' ] ) ) {
                        $errors[ 'description' ] = 'Ce texte n\'est pas valide.';
                    } elseif ( isset( $_POST[ 'description' ] ) && is_string( $_POST[ 'description' ] ) && !empty( $_POST[ 'description' ] ) ) {
                        $_SESSION[ 'publisher' ][ 'description' ] = $_POST[ 'description' ];
                    }

                    if ( isset( $errors ) ) {
                        return compact( 'view', 'page_title', 'page_description', 'errors' );
                    } else {
                        //update in DB
                        $publisher = $this -> model -> update( $publisherId, $_SESSION[ 'publisher' ][ 'name' ], $_SESSION[ 'publisher' ][ 'website' ], $_SESSION[ 'publisher' ][ 'logo' ], $_SESSION[ 'publisher' ][ 'description' ], date( 'Y-m-d' ) );

                        //redirect to author index
                        header( 'Location: ./index.php?ressource=publisher&action=view&id=' . $publisherId );
                        die();
                    }
                } else {
                    $errors[ 'name' ] = 'Votre éditeur doit avoir au moins un nom valide.';
                }
            }
        }
    }
}
