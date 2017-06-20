<?php

namespace Controllers;
use Models\Book as BookModel;
use Models\Author as AuthorModel;
use Models\Publisher as PublisherModel;
use Models\Type as TypeModel;
use DateTime;

class Book extends Controller {

    protected $model = null;

    function __construct () {
        $this -> model = new BookModel();
    }

    public function index () {
        $view = 'views/books/index.php';
        $page_title = 'Liste des Livres';
        $page_description = 'Liste des livres présents sur Ex Libris.';
        $lastBooks = $this -> model -> getLastBooks();
        if ( $lastBooks ) {
            $books = $this -> model -> getAllBooks();
            if ( $books ) {
                return compact( 'view', 'page_title', 'page_description', 'books', 'lastBooks' );
            }
        } else {
            $error = 'Il n\'y a aucun livre à afficher pour l\'instant.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }
    }

    public function view () {
        $view = 'views/books/view.php';
        $bookId = 0;
        if ( isset( $_REQUEST[ 'id' ] ) && ctype_digit( $_REQUEST[ 'id' ] ) ) {
            $bookId = $_REQUEST[ 'id' ];
        } else {
            $error = 'Identifiant invalide.';
            $page_title = 'Erreur';
            $page_description = 'Erreur - Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }

        $book = $this -> model -> getBook( $bookId );
        if ( $book ) {
            $book[ 'language' ] = $this -> model -> getLanguage( $book[ 'language_id' ] );
            $book[ 'location' ] = $this -> model -> getLocation( $book[ 'location_id' ] );
            $book[ 'othersFromPublisher' ] = $this -> model -> getBooksByPublisherId( $book[ 'editor_id' ] );
            $book[ 'othersFromType' ] = $this -> model -> getBooksByTypeId( $book[ 'genre_id' ] );
            $this -> model = new PublisherModel();
            $book[ 'publisher' ] = $this -> model -> getPublisher( $book[ 'editor_id' ] );
            $this -> model = new TypeModel();
            $book[ 'type' ] = $this -> model -> getType( $book[ 'genre_id' ] );
            $this -> model = new AuthorModel();
            $book[ 'authors' ] = $this -> model -> getAuthorsByBookId( $bookId );
            if ( isset( $book[ 'authors' ][ 0 ] ) ) {
                $this -> model = new BookModel();
                $book[ 'othersFromAuthor' ] = $this -> model -> getOtherBooksFromAuthor( $book[ 'id' ], $book[ 'authors' ][ 0 ][ 'id' ] );
            }

            $page_title = $book[ 'title' ];
            $page_description = 'Fiche du livre ' . $book[ 'title' ] . ' sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'book' );
        } else {
            $error = 'Ce livre n\'existe pas.';
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
            $_SESSION[ 'book' ] = null;
            $languages = $this -> model -> getAllLanguages();
            $locations = $this -> model -> getAllLocations();
            $this -> model = new PublisherModel();
            $publishers = $this -> model -> getAllPublishers();
            $this -> model = new TypeModel();
            $types = $this -> model -> getAllTypes();
            $this -> model = new AuthorModel();
            $authors = $this -> model -> getAllAuthors();
            $view = 'views/books/create.php';
            $page_title = 'Ajouter un livre';
            $page_description = 'Ajouter un livre sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'languages', 'locations', 'publishers', 'types', 'authors' );
        }
    }

    public function save () {
        $view = 'views/books/create.php';
        $page_title = 'Ajouter un livre';
        $page_description = 'Ajouter un livre sur Ex Libris.';

        $languages = $this -> model -> getAllLanguages();
        $locations = $this -> model -> getAllLocations();
        $this -> model = new PublisherModel();
        $publishers = $this -> model -> getAllPublishers();
        $this -> model = new TypeModel();
        $types = $this -> model -> getAllTypes();
        $this -> model = new AuthorModel();
        $authors = $this -> model -> getAllAuthors();
        $_SESSION[ 'book' ][ 'title' ] = $_POST[ 'title' ];
        $_SESSION[ 'book' ][ 'summary' ] = $_POST[ 'summary' ];
        $_SESSION[ 'book' ][ 'isbn' ] = $_POST[ 'isbn' ];
        $_SESSION[ 'book' ][ 'npages' ] = intval( $_POST[ 'npages' ] );
        $_SESSION[ 'book' ][ 'datepub-day' ] = intval( $_POST[ 'datepub-day' ] );
        $_SESSION[ 'book' ][ 'datepub-month' ] = intval( $_POST[ 'datepub-month' ] );
        $_SESSION[ 'book' ][ 'datepub-year' ] = intval( $_POST[ 'datepub-year' ] );
        $_SESSION[ 'book' ][ 'language_id' ] = intval( $_POST[ 'language_id' ] );
        $_SESSION[ 'book' ][ 'genre_id' ] = intval( $_POST[ 'genre_id' ] );
        $_SESSION[ 'book' ][ 'location_id' ] = intval( $_POST[ 'location_id' ] );
        $_SESSION[ 'book' ][ 'editor_id' ] = intval( $_POST[ 'editor_id' ] );

        if ( isset( $_POST[ 'title' ] ) ) {

            //check front_cover
            $destination = null;
            if ( isset( $_FILES[ 'front_cover' ] ) ) {
                if ( !$_FILES[ 'front_cover' ][ 'error' ] ) {
                    //check file type
                    $allowedTypes = [ 'image/jpg', 'image/jpeg' ];
                    if ( in_array( $_FILES[ 'front_cover' ][ 'type' ], $allowedTypes ) ) {
                        //file deplacing to keep permanent track
                        $typeParts = explode( '.', $_FILES[ 'front_cover' ][ 'name' ] );
                        $type = $typeParts[ count( $typeParts ) - 1 ];
                        $filename = 'f' . time() . rand( 1000, 9999 ) . '.' . $type;
                        $destination = './files/books/' . $filename; //must contain file name and type

                        //--- IMAGE UPLOAD AND HANDLING (using 'GD')
                        list( $width, $height ) = getimagesize( $_FILES[ 'front_cover' ][ 'tmp_name' ] );
                        $redim = imagecreatetruecolor( 300, 450 ); //POINTS TOWARD RESSOURCE, NOT A PATH
                        $image = imagecreatefromjpeg( $_FILES[ 'front_cover' ][ 'tmp_name' ] ); //POINTS TOWARD RESSOURCE, NOT A PATH
                        imagecopyresampled( $redim, $image, 0, 0, 0, 0, 300, 450, $width, $height);
                        imagejpeg( $redim, $destination, 100 );
                    } else {
                        $errors[ 'front_cover' ] = 'Type de fichier non-valide. Seuls les images JPEG sont autorisées.';
                    }
                } else {
                    $errors[ 'front_cover' ] = 'Le fichier n\'a pas pu être envoyé.';
                }
            }

            //check summary
            if ( isset( $_POST[ 'summary' ] ) && !is_string( $_POST[ 'summary' ] ) ) {
                $errors[ 'summary' ] = 'Ce résumé n\'est pas valide.';
            }

            //check isbn

            //check datepub
            $datepub = new DateTime( $_POST[ 'datepub-year' ] . '-' . $_POST[ 'datepub-month' ] . '-' . $_POST[ 'datepub-day' ] );
            if ( isset( $_POST[ 'datepub-day' ], $_POST[ 'datepub-month' ], $_POST[ 'datepub-year' ] ) ) {
                if ( checkdate( $_SESSION[ 'book' ][ 'datepub-month' ], $_SESSION[ 'book' ][ 'datepub-day' ], $_SESSION[ 'book' ][ 'datepub-year' ] ) ) {
                    $datepub = new DateTime( strval( $_SESSION[ 'book' ][ 'datepub-year' ] ) . '-' . strval( $_SESSION[ 'book' ][ 'datepub-month' ] ) . '-' . strval( $_SESSION[ 'book' ][ 'datepub-day' ] ) );
                } else {
                    $errors[ 'datepub' ] = 'Cette date n\'est pas valide.';
                }
            }

            if ( isset( $errors ) ) {
                return compact( 'view', 'page_title', 'page_description', 'errors', 'languages', 'locations', 'publishers', 'types', 'authors' );
            } else {
                //create in DB
                $this -> model = new BookModel();
                $book = $this -> model -> save( $_POST[ 'title' ], $destination, $_POST[ 'summary' ], $_POST[ 'isbn' ], $_SESSION[ 'book' ][ 'npages' ], $datepub, $_SESSION[ 'book' ][ 'language_id' ], $_SESSION[ 'book' ][ 'genre_id' ], $_SESSION[ 'book' ][ 'location_id' ], $_SESSION[ 'book' ][ 'editor_id' ] );
                if ( isset( $_POST[ 'authors_id' ] ) ) {
                    foreach ( $_POST[ 'authors_id' ] as $author_id )
            		{
            			$this -> model -> attachAuthors( $book[ 'id' ], intval( $author_id ) );
            		}
                }

                //redirect to book index
                header( 'Location: ./index.php?ressource=book&action=index' );
                die();
            }
        } else {
            $errors[ 'title' ] = 'Il faut au moins un titre à votre livre.';
            return compact( 'view', 'page_title', 'page_description', 'errors', 'languages', 'locations', 'publishers', 'types', 'authors' );
        }
    }

    public function delete () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            if ( isset( $_GET[ 'id' ] ) ) {
                $bookId = intval( $_GET[ 'id' ] );
                $book = $this -> model -> getBook( $bookId );
                if ( $book ) {
                    //detach all authors from book
                    $this -> model = new AuthorModel();
                    $authors = $this -> model -> getAuthorsByBookId( $bookId );
                    foreach ( $authors as $author ) {
                        $this -> model -> detachAuthors( $bookId, $author[ 'id' ] );
                    }
                    //delete book
                    $this -> model = new BookModel();
                    $this -> model -> deleteBook( $bookId );

                    header( 'Location: ./index.php?ressource=book&action=index' );
                    die();
                } else {
                    //book doesn't exist
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
                $bookId = intval( $_GET[ 'id' ] );
                $book = $this -> model -> getBook( $bookId );
                if ( $book ) {
                    $_SESSION[ 'book' ] = $book;
                    $_SESSION[ 'book' ][ 'datepub-year' ] = null;
                    $_SESSION[ 'book' ][ 'datepub-month' ] = null;
                    $_SESSION[ 'book' ][ 'datepub-day' ] = null;
                    if( isset( $book[ 'datepub' ] ) && !empty( $book[ 'datepub' ] ) ) {
                        $pubdate = explode( '-', $book[ 'datepub' ] );
                        $_SESSION[ 'book' ][ 'datepub-year' ] = $pubdate[ 0 ];
                        $_SESSION[ 'book' ][ 'datepub-month' ] = $pubdate[ 1 ];
                        $_SESSION[ 'book' ][ 'datepub-day' ] = $pubdate[ 2 ];
                    }

                    $languages = $this -> model -> getAllLanguages();
                    $locations = $this -> model -> getAllLocations();
                    $this -> model = new PublisherModel();
                    $publishers = $this -> model -> getAllPublishers();
                    $this -> model = new TypeModel();
                    $types = $this -> model -> getAllTypes();
                    $this -> model = new AuthorModel();
                    $authors = $this -> model -> getAllAuthors();
                    $_SESSION[ 'book' ][ 'authors' ] = $this -> model -> getAuthorsByBookId( $bookId );
                    $view = 'views/books/edit.php';
                    $page_title = 'Modifier un livre';
                    $page_description = 'Modifier un livre sur Ex Libris.';
                    return compact( 'view', 'page_title', 'page_description', 'languages', 'locations', 'publishers', 'types', 'authors' );
                } else {
                    //book doesn't exist
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
            if ( isset( $_POST[ 'bookId' ] ) ) {
                $bookId = intval( $_POST[ 'bookId' ] );
                $book = $this -> model -> getBook( $bookId );
                if ( $book ) {
                    //get all values from $_POST and validate them
                    $view = 'views/books/edit.php';
                    $page_title = 'Modifier un livre';
                    $page_description = 'Modifier un livre sur Ex Libris.';

                    $_SESSION[ 'book' ] = $book;
                    $_SESSION[ 'book' ][ 'datepub-year' ] = null;
                    $_SESSION[ 'book' ][ 'datepub-month' ] = null;
                    $_SESSION[ 'book' ][ 'datepub-day' ] = null;
                    if( isset( $book[ 'datepub' ] ) && !empty( $book[ 'datepub' ] ) ) {
                        $pubdate = explode( '-', $book[ 'datepub' ] );
                        $_SESSION[ 'book' ][ 'datepub-year' ] = $pubdate[ 0 ];
                        $_SESSION[ 'book' ][ 'datepub-month' ] = $pubdate[ 1 ];
                        $_SESSION[ 'book' ][ 'datepub-day' ] = $pubdate[ 2 ];
                    }

                    $languages = $this -> model -> getAllLanguages();
                    $locations = $this -> model -> getAllLocations();
                    $this -> model = new PublisherModel();
                    $publishers = $this -> model -> getAllPublishers();
                    $this -> model = new TypeModel();
                    $types = $this -> model -> getAllTypes();
                    $this -> model = new AuthorModel();
                    $authors = $this -> model -> getAllAuthors();

                    $_SESSION[ 'book' ][ 'language_id' ] = intval( $_POST[ 'language_id' ] );
                    $_SESSION[ 'book' ][ 'genre_id' ] = intval( $_POST[ 'genre_id' ] );
                    $_SESSION[ 'book' ][ 'location_id' ] = intval( $_POST[ 'location_id' ] );
                    $_SESSION[ 'book' ][ 'editor_id' ] = intval( $_POST[ 'editor_id' ] );

                    if ( isset( $_POST[ 'title' ] ) ) {
                        $_SESSION[ 'book' ][ 'title' ] = $_POST[ 'title' ];
                        //check front_cover
                        if ( isset( $_FILES[ 'front_cover' ] ) && !empty( $_FILES[ 'front_cover' ] ) && !empty( $_FILES[ 'front_cover' ][ 'type' ] ) ) {
                            if ( !$_FILES[ 'front_cover' ][ 'error' ] ) {
                                //check file type
                                $allowedTypes = [ 'image/jpg', 'image/jpeg' ];
                                if ( isset( $_FILES[ 'front_cover' ][ 'type' ] ) && !empty( $_FILES[ 'front_cover' ][ 'type' ] ) && in_array( $_FILES[ 'front_cover' ][ 'type' ], $allowedTypes ) ) {
                                    //file deplacing to keep permanent track
                                    $typeParts = explode( '.', $_FILES[ 'front_cover' ][ 'name' ] );
                                    $type = $typeParts[ count( $typeParts ) - 1 ];
                                    $filename = 'f' . time() . rand( 1000, 9999 ) . '.' . $type;
                                    $destination = './files/books/' . $filename; //must contain file name and type

                                    //--- IMAGE UPLOAD AND HANDLING (using 'GD')
                                    list( $width, $height ) = getimagesize( $_FILES[ 'front_cover' ][ 'tmp_name' ] );
                                    $redim = imagecreatetruecolor( 300, 450 ); //POINTS TOWARD RESSOURCE, NOT A PATH
                                    $image = imagecreatefromjpeg( $_FILES[ 'front_cover' ][ 'tmp_name' ] ); //POINTS TOWARD RESSOURCE, NOT A PATH
                                    imagecopyresampled( $redim, $image, 0, 0, 0, 0, 300, 450, $width, $height);
                                    imagejpeg( $redim, $destination, 100 );
                                    //delete old picture from server before assigning new one
                                    unlink( $_SESSION[ 'book' ][ 'front_cover' ] );
                                    $_SESSION[ 'book' ][ 'front_cover' ] = $destination;
                                } else {
                                    $errors[ 'front_cover' ] = 'Type de fichier non-valide. Seuls les images JPEG sont autorisées.';
                                }
                            } else {
                                //$errors[ 'front_cover' ] = 'Le fichier n\'a pas pu être envoyé.';
                            }
                        }

                        //check if photo is to be erased
                        if ( isset( $_POST[ 'eraseCover' ] ) && $_POST[ 'eraseCover' ] == "on" ) {
                            unlink( $_SESSION[ 'book' ][ 'front_cover' ] );
                            $_SESSION[ 'book' ][ 'cover' ] = null;
                        }

                        //check summary
                        if ( isset( $_POST[ 'summary' ] ) && !is_string( $_POST[ 'summary' ] ) && !empty( $_POST[ 'summary' ] ) ) {
                            $errors[ 'summary' ] = 'Ce résumé n\'est pas valide.';
                        } elseif ( isset( $_POST[ 'summary' ] ) && is_string( $_POST[ 'summary' ] ) && !empty( $_POST[ 'summary' ] ) ) {
                            $_SESSION[ 'book' ][ 'summary' ] = $_POST[ 'summary' ];
                        }

                        //check isbn
                        if ( isset( $_POST[ 'isbn' ] ) ) {
                            $_SESSION[ 'book' ][ 'isbn' ] = $_POST[ 'isbn' ];
                        }

                        //check npages
                        if ( isset( $_POST[ 'npages' ] ) ) {
                            $_SESSION[ 'book' ][ 'npages' ] = intval( $_POST[ 'npages' ] );
                        }

                        //check datepub
                        $datepub = null;
                        if( isset( $book[ 'datepub' ] ) && !empty( $book[ 'datepub' ] ) ) {
                            $datepub = $_SESSION[ 'book' ][ 'datepub-year' ] . '-' . $_SESSION[ 'book' ][ 'datepub-month' ] . '-' . $_SESSION[ 'book' ][ 'datepub-day' ];
                        }
                        $datepub = $_SESSION[ 'book' ][ 'datepub-year' ] . '-' . $_SESSION[ 'book' ][ 'datepub-month' ] . '-' . $_SESSION[ 'book' ][ 'datepub-day' ];
                        if ( isset( $_POST[ 'datepub-day' ], $_POST[ 'datepub-month' ], $_POST[ 'datepub-year' ] ) ) {
                            if ( checkdate( intval( $_POST[ 'datepub-month' ] ), intval( $_POST[ 'datepub-day' ] ), intval( $_POST[ 'datepub-year' ] ) ) ) {
                                $datepub = new DateTime( $_POST[ 'datepub-year' ] . '-' . $_POST[ 'datepub-month' ] . '-' . $_POST[ 'datepub-day' ] );
                                var_dump( $datepub ); //Strangely, removing this prevents the DateTime to be saved properly in database
                            } else {
                                $errors[ 'datepub' ] = 'Cette date n\'est pas valide.';
                            }
                        }

                        if ( isset( $errors ) ) {
                            return compact( 'view', 'page_title', 'page_description', 'errors', 'languages', 'locations', 'publishers', 'types', 'authors' );
                        } else {
                            //update in DB
                            $this -> model = new BookModel();
                            $book = $this -> model -> update( $bookId, $_POST[ 'title' ], $_SESSION[ 'book' ][ 'front_cover' ], $_POST[ 'summary' ], $_POST[ 'isbn' ], $_SESSION[ 'book' ][ 'npages' ], $datepub, $_SESSION[ 'book' ][ 'language_id' ], $_SESSION[ 'book' ][ 'genre_id' ], $_SESSION[ 'book' ][ 'location_id' ], $_SESSION[ 'book' ][ 'editor_id' ] );

                            if ( isset( $_POST[ 'authors_id' ] ) ) {
                                $this -> model -> resetAuthors( $bookId );
                                foreach ( $_POST[ 'authors_id' ] as $author_id )
                        		{
                        			$this -> model -> attachAuthors( $bookId, intval( $author_id ) );
                        		}
                            }

                            //redirect to newly updated book
                            header( 'Location: ./index.php?ressource=book&action=view&id=' . $bookId );
                            die();
                        }
                    } else {
                        $errors[ 'title' ] = 'Il faut au moins un titre à votre livre.';
                        return compact( 'view', 'page_title', 'page_description', 'errors', 'languages', 'locations', 'publishers', 'types', 'authors' );
                    }
                } else {
                    //book doesn't exist
                }
            } else {
                //invalid ID
            }
        }
    }

}
