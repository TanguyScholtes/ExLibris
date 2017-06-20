<?php

namespace Controllers;
use Models\Author as AuthorModel;
use Models\Book as BookModel;
use DateTime;

class Author extends Controller {

    protected $model = null;

    function __construct () {
        $this -> model = new AuthorModel();
    }

    public function index () {
        $view = 'views/authors/index.php';
        $page_title = 'Liste des Auteurs';
        $page_description = 'Liste des auteurs présents sur Ex Libris.';
        $authors = $this -> model -> getAllAuthors();
        if ( $authors ) {
                return compact( 'view', 'page_title', 'page_description', 'authors' );
        } else {
            $error = 'Il n\'y a aucun auteur à afficher pour l\'instant.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }
    }

    public function view () {
        $view = 'views/authors/view.php';
        $authorId = 0;
        if ( isset( $_REQUEST[ 'id' ] ) && ctype_digit( $_REQUEST[ 'id' ] ) ) {
            $authorId = $_REQUEST[ 'id' ];
        } else {
            $error = 'Identifiant invalide.';
            $page_title = 'Erreur';
            $page_description = 'Erreur - Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }

        $author = $this -> model -> getAuthor( $authorId );
        if ( $author ) {
            $this -> model = new BookModel();
            $author[ 'books' ] = $this -> model -> getBooksByAuthorId( $authorId );

            $page_title = $author[ 'first_name' ] . ' ' . $author[ 'name' ];
            $page_description = 'Fiche de l\'auteur ' . $author[ 'first_name' ] . ' ' . $author[ 'name' ] . ' sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'author' );
        } else {
            $error = 'Cet auteur n\'existe pas.';
            $page_title = 'Erreur';
            $page_description = 'Erreur - Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }
    }

    public function delete () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            if ( isset( $_GET[ 'id' ] ) ) {
                $authorId = intval( $_GET[ 'id' ] );
                $author = $this -> model -> getAuthor( $authorId );
                if ( $author ) {
                    //detach all books from author
                    $this -> model = new BookModel();
                    $books = $this -> model -> getBooksByAuthorId( $authorId );
                    foreach ( $books as $book ) {
                        $this -> model -> detachAuthors( $book[ 'id' ], $authorId );
                    }
                    //delete author
                    $this -> model = new AuthorModel();
                    $this -> model -> deleteAuthor( $authorId );

                    header( 'Location: ./index.php?ressource=author&action=index' );
                    die();
                } else {
                    //author doesn't exist
                }
            } else {
                //invalid ID
            }
        }
    }

    public function create () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            $_SESSION[ 'author' ] = null;
            $view = 'views/authors/create.php';
            $page_title = 'Ajouter un auteur';
            $page_description = 'Ajouter un auteur sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description' );
        }
    }

    public function save () {
        $view = 'views/authors/create.php';
        $page_title = 'Ajouter un auteur';
        $page_description = 'Ajouter un auteur sur Ex Libris.';

        $_SESSION[ 'author' ][ 'name' ] = $_POST[ 'name' ];
        $_SESSION[ 'author' ][ 'first_name' ] = $_POST[ 'first_name' ];
        $_SESSION[ 'author' ][ 'datebirth-month' ] = intval( $_POST[ 'datebirth-month' ] );
        $_SESSION[ 'author' ][ 'datebirth-day' ] = intval( $_POST[ 'datebirth-day' ] );
        $_SESSION[ 'author' ][ 'datebirth-year' ] = intval( $_POST[ 'datebirth-year' ] );
        $_SESSION[ 'author' ][ 'datedeath-month' ] = intval( $_POST[ 'datedeath-month' ] );
        $_SESSION[ 'author' ][ 'datedeath-day' ] = intval( $_POST[ 'datedeath-day' ] );
        $_SESSION[ 'author' ][ 'datedeath-year' ] = intval( $_POST[ 'datedeath-year' ] );
        $_SESSION[ 'author' ][ 'bio' ] = $_POST[ 'bio' ];

        if( isset( $_POST[ 'name' ] ) && isset( $_POST[ 'first_name' ] ) ) {
            //check photo
            $destination = null;
            if ( isset( $_FILES[ 'photo' ] ) ) {
                if ( !$_FILES[ 'photo' ][ 'error' ] ) {
                    //check file type
                    $allowedTypes = [ 'image/jpg', 'image/jpeg' ];
                    if ( in_array( $_FILES[ 'photo' ][ 'type' ], $allowedTypes ) ) {
                        //file deplacing to keep permanent track
                        $typeParts = explode( '.', $_FILES[ 'photo' ][ 'name' ] );
                        $type = $typeParts[ count( $typeParts ) - 1 ];
                        $filename = 'f' . time() . rand( 1000, 9999 ) . '.' . $type;
                        $destination = './files/authors/' . $filename; //must contain file name and type

                        //--- IMAGE UPLOAD AND HANDLING (using 'GD')
                        list( $width, $height ) = getimagesize( $_FILES[ 'photo' ][ 'tmp_name' ] );
                        $redim = imagecreatetruecolor( 300, 450 ); //POINTS TOWARD RESSOURCE, NOT A PATH
                        $image = imagecreatefromjpeg( $_FILES[ 'photo' ][ 'tmp_name' ] ); //POINTS TOWARD RESSOURCE, NOT A PATH
                        imagecopyresampled( $redim, $image, 0, 0, 0, 0, 300, 450, $width, $height);
                        imagejpeg( $redim, $destination, 100 );
                    } else {
                        $errors[ 'photo' ] = 'Type de fichier non-valide. Seuls les images JPEG sont autorisées.';
                    }
                } else {
                    $errors[ 'photo' ] = 'Le fichier n\'a pas pu être envoyé.';
                }
            }

            //check datebirth
            $datedeath = null;
            if ( isset( $_POST[ 'datebirth-day' ], $_POST[ 'datebirth-month' ], $_POST[ 'datebirth-year' ] ) ) {
                if ( checkdate( $_SESSION[ 'author' ][ 'datebirth-month' ], $_SESSION[ 'author' ][ 'datebirth-day' ], $_SESSION[ 'author' ][ 'datebirth-year' ] ) ) {
                    $datebirth = new DateTime( strval( $_SESSION[ 'author' ][ 'datebirth-year' ] ) . '-' . strval( $_SESSION[ 'author' ][ 'datebirth-month' ] ) . '-' . strval( $_SESSION[ 'author' ][ 'datebirth-day' ] ) );
                } else {
                    $errors[ 'datebirth' ] = 'Cette date n\'est pas valide.';
                }
            }

            //check datedeath
            $datedeath = null;
            if ( isset( $_POST[ 'datedeath-day' ], $_POST[ 'datedeath-month' ], $_POST[ 'datedeath-year' ] ) ) {
                if ( checkdate( $_SESSION[ 'author' ][ 'datedeath-month' ], $_SESSION[ 'author' ][ 'datedeath-day' ], $_SESSION[ 'author' ][ 'datedeath-year' ] ) ) {
                    $datedeath = new DateTime( strval( $_SESSION[ 'author' ][ 'datedeath-year' ] ) . '-' . strval( $_SESSION[ 'author' ][ 'datedeath-month' ] ) . '-' . strval( $_SESSION[ 'author' ][ 'datedeath-day' ] ) );
                } else {
                    //$errors[ 'datedeath' ] = 'Cette date n\'est pas valide.';
                }
            }

            //check bio
            if ( isset( $_POST[ 'bio' ] ) && !is_string( $_POST[ 'bio' ] ) ) {
                $errors[ 'bio' ] = 'Ce texte n\'est pas valide.';
            }

            if ( isset( $errors ) ) {
                return compact( 'view', 'page_title', 'page_description', 'errors' );
            } else {
                //create in DB
                $this -> model = new AuthorModel();
                $author = $this -> model -> save( $_SESSION[ 'author'][ 'name' ], $_SESSION[ 'author'][ 'first_name' ], $destination, $datebirth, $datedeath, $_SESSION[ 'author'][ 'bio' ] );

                //redirect to author index
                header( 'Location: ./index.php?ressource=author&action=index' );
                die();
            }
        } else {
            $errors[ 'name' ] = 'L\'auteur doit avoir un nom et un prénom valides.';
            $errors[ 'first_name' ] = 'L\'auteur doit avoir un nom et un prénom valides.';
        }
    }

    public function edit () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            if ( isset( $_GET[ 'id' ] ) ) {
                $authorId = intval( $_GET[ 'id' ] );
                $author = $this -> model -> getAuthor( $authorId );
                if ( $author ) {
                    $_SESSION[ 'author' ] = $author;
                    $_SESSION[ 'author' ][ 'datebirth-year' ] = null;
                    $_SESSION[ 'author' ][ 'datebirth-month' ] = null;
                    $_SESSION[ 'author' ][ 'datebirth-day' ] = null;
                    $_SESSION[ 'author' ][ 'datedeath-year' ] = null;
                    $_SESSION[ 'author' ][ 'datedeath-month' ] = null;
                    $_SESSION[ 'author' ][ 'datedeath-day' ] = null;
                    if( isset( $author[ 'datebirth' ] ) && !empty( $author[ 'datebirth' ] ) ) {
                        $datebirth = explode( '-', $author[ 'datebirth' ] );
                        $_SESSION[ 'author' ][ 'datebirth-year' ] = $datebirth[ 0 ];
                        $_SESSION[ 'author' ][ 'datebirth-month' ] = $datebirth[ 1 ];
                        $_SESSION[ 'author' ][ 'datebirth-day' ] = $datebirth[ 2 ];
                    }
                    if( isset( $author[ 'datedeath' ] ) && !empty( $author[ 'datedeath' ] ) ) {
                        $datedeath = explode( '-', $author[ 'datedeath' ] );
                        $_SESSION[ 'author' ][ 'datedeath-year' ] = $datedeath[ 0 ];
                        $_SESSION[ 'author' ][ 'datedeath-month' ] = $datedeath[ 1 ];
                        $_SESSION[ 'author' ][ 'datedeath-day' ] = $datedeath[ 2 ];
                    }

                    $view = 'views/authors/edit.php';
                    $page_title = 'Modifier un auteur';
                    $page_description = 'Modifier un auteur sur Ex Libris.';
                    return compact( 'view', 'page_title', 'page_description' );
                } else {
                    //author doesn't exist
                }
            } else {
                //invalid ID
            }
        }
    }

    public function update () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            if ( isset( $_POST[ 'authorId' ] ) ) {
                $authorId = intval( $_POST[ 'authorId' ] );
                $author = $this -> model -> getAuthor( $authorId );
                if ( $author ) {
                    //get all values from $_POST and validate them
                    $view = 'views/authors/edit.php';
                    $page_title = 'Modifier un auteur';
                    $page_description = 'Modifier un auteur sur Ex Libris.';

                    $_SESSION[ 'author' ] = $author;
                    $_SESSION[ 'author' ][ 'datebirth-year' ] = null;
                    $_SESSION[ 'author' ][ 'datebirth-month' ] = null;
                    $_SESSION[ 'author' ][ 'datebirth-day' ] = null;
                    $_SESSION[ 'author' ][ 'datedeath-year' ] = null;
                    $_SESSION[ 'author' ][ 'datedeath-month' ] = null;
                    $_SESSION[ 'author' ][ 'datedeath-day' ] = null;
                    if( isset( $author[ 'datebirth' ] ) && !empty( $author[ 'datebirth' ] ) ) {
                        $datebirth = explode( '-', $author[ 'datebirth' ] );
                        $_SESSION[ 'author' ][ 'datebirth-year' ] = $datebirth[ 0 ];
                        $_SESSION[ 'author' ][ 'datebirth-month' ] = $datebirth[ 1 ];
                        $_SESSION[ 'author' ][ 'datebirth-day' ] = $datebirth[ 2 ];
                    }
                    if( isset( $author[ 'datedeath' ] ) && !empty( $author[ 'datedeath' ] ) ) {
                        $datedeath = explode( '-', $author[ 'datedeath' ] );
                        $_SESSION[ 'author' ][ 'datedeath-year' ] = $datedeath[ 0 ];
                        $_SESSION[ 'author' ][ 'datedeath-month' ] = $datedeath[ 1 ];
                        $_SESSION[ 'author' ][ 'datedeath-day' ] = $datedeath[ 2 ];
                    }

                    if( isset( $_POST[ 'name' ] ) && isset( $_POST[ 'first_name' ] ) ) {
                        $_SESSION[ 'author' ][ 'name' ] = $_POST[ 'name' ];
                        $_SESSION[ 'author' ][ 'first_name' ] = $_POST[ 'first_name' ];

                        //check photo
                        if ( isset( $_FILES[ 'photo' ] ) && !empty( $_FILES[ 'photo' ] ) && !empty( $_FILES[ 'photo' ][ 'type' ] ) ) {
                            if ( !$_FILES[ 'photo' ][ 'error' ] ) {
                                //check file type
                                $allowedTypes = [ 'image/jpg', 'image/jpeg' ];
                                if ( isset( $_FILES[ 'photo' ][ 'type' ] ) && !empty( $_FILES[ 'photo' ][ 'type' ] ) && in_array( $_FILES[ 'photo' ][ 'type' ], $allowedTypes ) ) {
                                    //file deplacing to keep permanent track
                                    $typeParts = explode( '.', $_FILES[ 'photo' ][ 'name' ] );
                                    $type = $typeParts[ count( $typeParts ) - 1 ];
                                    $filename = 'f' . time() . rand( 1000, 9999 ) . '.' . $type;
                                    $destination = './files/authors/' . $filename; //must contain file name and type

                                    //--- IMAGE UPLOAD AND HANDLING (using 'GD')
                                    list( $width, $height ) = getimagesize( $_FILES[ 'photo' ][ 'tmp_name' ] );
                                    $redim = imagecreatetruecolor( 300, 450 ); //POINTS TOWARD RESSOURCE, NOT A PATH
                                    $image = imagecreatefromjpeg( $_FILES[ 'photo' ][ 'tmp_name' ] ); //POINTS TOWARD RESSOURCE, NOT A PATH
                                    imagecopyresampled( $redim, $image, 0, 0, 0, 0, 300, 450, $width, $height);
                                    imagejpeg( $redim, $destination, 100 );
                                    unlink( $_SESSION[ 'author' ][ 'photo' ] );
                                    $_SESSION[ 'author' ][ 'photo' ] = $destination;
                                } else {
                                    $errors[ 'photo' ] = 'Type de fichier non-valide. Seuls les images JPEG sont autorisées.';
                                }
                            } else {
                                //$errors[ 'photo' ] = 'Le fichier n\'a pas pu être envoyé.';
                            }
                        }

                        //check if photo is to be erased
                        if ( isset( $_POST[ 'erasePhoto' ] ) && $_POST[ 'erasePhoto' ] == "on" ) {
                            unlink( $_SESSION[ 'author' ][ 'photo' ] );
                            $_SESSION[ 'author' ][ 'photo' ] = null;
                        }

                        //check datebirth
                        $datebirth = null;
                        if( isset( $author[ 'datebirth' ] ) && !empty( $author[ 'datebirth' ] ) ) {
                            $datebirth = $_SESSION[ 'author' ][ 'datebirth-year' ] . '-' . $_SESSION[ 'author' ][ 'datebirth-month' ] . '-' . $_SESSION[ 'author' ][ 'datebirth-day' ];
                        }
                        if ( isset( $_POST[ 'datebirth-day' ], $_POST[ 'datebirth-month' ], $_POST[ 'datebirth-year' ] ) && !empty( $_POST[ 'datebirth-day' ] ) && !empty( $_POST[ 'datebirth-month' ] ) && !empty( $_POST[ 'datebirth-year' ] ) ) {
                            if ( checkdate( intval( $_POST[ 'datebirth-month' ] ), intval( $_POST[ 'datebirth-day' ] ), intval( $_POST[ 'datebirth-year' ] ) ) ) {
                                $datebirth = new DateTime( $_POST[ 'datebirth-year' ] . '-' . $_POST[ 'datebirth-month' ] . '-' . $_POST[ 'datebirth-day' ] );
                                var_dump( $datebirth ); //Strangely, removing this prevents the DateTime to be saved properly in database
                                $_SESSION[ 'author' ][ 'datebirth' ] = $datebirth -> date;
                            } else {
                                $errors[ 'datebirth' ] = 'Cette date n\'est pas valide.';
                            }
                        }

                        //check datedeath
                        $datedeath = null;
                        if( isset( $author[ 'datedeath' ] ) && !empty( $author[ 'datedeath' ] ) ) {
                            $datedeath = $_SESSION[ 'author' ][ 'datedeath-year' ] . '-' . $_SESSION[ 'author' ][ 'datedeath-month' ] . '-' . $_SESSION[ 'author' ][ 'datedeath-day' ];
                        }
                        if ( isset( $_POST[ 'datedeath-day' ], $_POST[ 'datedeath-month' ], $_POST[ 'datedeath-year' ] ) && !empty( $_POST[ 'datedeath-day' ] ) && !empty( $_POST[ 'datedeath-month' ] ) && !empty( $_POST[ 'datedeath-year' ] ) ) {
                            if ( checkdate( intval( $_POST[ 'datedeath-month' ] ), intval( $_POST[ 'datedeath-day' ] ), intval( $_POST[ 'datedeath-year' ] ) ) ) {
                                $datedeath = new DateTime( $_POST[ 'datedeath-year' ] . '-' . $_POST[ 'datedeath-month' ] . '-' . $_POST[ 'datedeath-day' ] );
                                var_dump( $datedeath ); //Strangely, removing this prevents the DateTime to be saved properly in database
                                $_SESSION[ 'author' ][ 'datedeath' ] = $datedeath -> date;
                            } else {
                                $errors[ 'datedeath' ] = 'Cette date n\'est pas valide.';
                            }
                        }

                        //check bio
                        if ( isset( $_POST[ 'bio' ] ) && !is_string( $_POST[ 'bio' ] ) && !empty( $_POST[ 'bio' ] ) ) {
                            $errors[ 'bio' ] = 'Ce texte n\'est pas valide.';
                        } elseif ( isset( $_POST[ 'bio' ] ) && is_string( $_POST[ 'bio' ] ) && !empty( $_POST[ 'bio' ] ) ) {
                            $_SESSION[ 'author' ][ 'bio' ] = $_POST[ 'bio' ];
                        }

                        if ( isset( $errors ) ) {
                            return compact( 'view', 'page_title', 'page_description', 'errors' );
                        } else {
                            echo('hello');
                            //update in DB
                            $this -> model = new AuthorModel();
                            $author = $this -> model -> update( $authorId, $_SESSION[ 'author' ][ 'name' ], $_SESSION[ 'author' ][ 'first_name' ], $_SESSION[ 'author' ][ 'photo' ], $_SESSION[ 'author' ][ 'datebirth' ], $_SESSION[ 'author' ][ 'datedeath' ], $_SESSION[ 'author' ][ 'bio' ], date( 'Y-m-d' ) );

                            //redirect to author index
                            header( 'Location: ./index.php?ressource=author&action=view&id=' . $authorId );
                            die();
                        }
                    } else {
                        $errors[ 'name' ] = 'L\'auteur doit avoir un nom et un prénom valides.';
                        $errors[ 'first_name' ] = 'L\'auteur doit avoir un nom et un prénom valides.';
                    }
                }
            }
        }
    }
}
