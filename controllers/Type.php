<?php

namespace Controllers;
use Models\Type as TypeModel;
use Models\Book as BookModel;
use Models\Author as AuthorModel;

class Type extends Controller {

    protected $model = null;

    function __construct () {
        $this -> model = new TypeModel();
    }

    public function index () {
        $view = 'views/types/index.php';
        $page_title = 'Liste des Genres';
        $page_description = 'Liste des genres présents sur Ex Libris.';
        $types = $this -> model -> getAllTypes();
        if ( $types ) {
                return compact( 'view', 'page_title', 'page_description', 'types' );
        } else {
            $error = 'Il n\'y a aucun éditeur à afficher pour l\'instant.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }
    }

    public function view () {
        $view = 'views/types/view.php';
        $typeId = 0;
        if ( isset( $_REQUEST[ 'id' ] ) && ctype_digit( $_REQUEST[ 'id' ] ) ) {
            $typeId = $_REQUEST[ 'id' ];
        } else {
            $error = 'Identifiant invalide.';
            $page_title = 'Erreur';
            $page_description = 'Erreur - Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'error' );
        }

        $type = $this -> model -> getType( $typeId );
        if ( $type ) {
            $this -> model = new BookModel();
            $type[ 'books' ] = $this -> model -> getBooksByTypeId( $typeId );
            $this -> model = new AuthorModel();
            $type[ 'authors' ] = $this -> model -> getAuthorsByTypeId( $typeId );

            $page_title = $type[ 'name' ];
            $page_description = 'Fiche du genre ' . $type[ 'name' ] . ' sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description', 'type' );
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
            $_SESSION[ 'type' ] = null;
            $view = 'views/types/create.php';
            $page_title = 'Ajouter un genre';
            $page_description = 'Ajouter un genre sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description' );
        }
    }

    public function save () {
        $view = 'views/types/create.php';
        $page_title = 'Ajouter un genre';
        $page_description = 'Ajouter un genre sur Ex Libris.';

        $_SESSION[ 'type' ][ 'name' ] = $_POST[ 'name' ];
        $_SESSION[ 'type' ][ 'description' ] = $_POST[ 'description' ];

        if( isset( $_POST[ 'name' ] ) ) {
            //check description
            if ( isset( $_POST[ 'description' ] ) && !is_string( $_POST[ 'description' ] ) && !empty( $_POST[ 'description' ] ) ) {
                $errors[ 'description' ] = 'Ce texte n\'est pas valide.';
            }

            if ( isset( $errors ) ) {
                return compact( 'view', 'page_title', 'page_description', 'errors' );
            } else {
                //create in DB
                $type = $this -> model -> save( $_SESSION[ 'type' ][ 'name' ], $_SESSION[ 'type' ][ 'description' ] );

                //redirect to publisher index
                header( 'Location: ./index.php?ressource=type&action=index' );
                die();
            }
        } else {
            $errors[ 'name' ] = 'Votre genre doit avoir au moins un nom valide.';
        }
    }

    public function delete () {
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        } else {
            if ( isset( $_GET[ 'id' ] ) ) {
                $typeId = intval( $_GET[ 'id' ] );
                $type = $this -> model -> getType( $typeId );
                if ( $type ) {
                    //delete publisher
                    $this -> model -> deleteType( $typeId );

                    header( 'Location: ./index.php?ressource=type&action=index' );
                    die();
                } else {
                    //type doesn't exist
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
                $typeId = intval( $_GET[ 'id' ] );
                $type = $this -> model -> getType( $typeId );
                if ( $type ) {
                    $_SESSION[ 'type' ] = $type;

                    $view = 'views/types/edit.php';
                    $page_title = 'Modifier un genre';
                    $page_description = 'Modifier un genre sur Ex Libris.';
                    return compact( 'view', 'page_title', 'page_description' );
                } else {
                    //type doesn't exist
                }
            } else {
                //invalid ID
            }
        }
    }

    public function update () {
        $view = 'views/types/edit.php';
        $page_title = 'Modifier un genre';
        $page_description = 'Modifier un genre sur Ex Libris.';

        if ( isset( $_POST[ 'typeId' ] ) ) {
            $typeId = intval( $_POST[ 'typeId' ] );
            $type = $this -> model -> getType( $typeId );
            if ( $type ) {
                $_SESSION[ 'type' ] = $type;

                if( isset( $_POST[ 'name' ] ) ) {
                    $_SESSION[ 'type' ][ 'name' ] = $_POST[ 'name' ];

                    //check description
                    if ( isset( $_POST[ 'description' ] ) && !is_string( $_POST[ 'description' ] ) && !empty( $_POST[ 'description' ] ) ) {
                        $errors[ 'description' ] = 'Ce texte n\'est pas valide.';
                    } elseif ( isset( $_POST[ 'description' ] ) && is_string( $_POST[ 'description' ] ) && !empty( $_POST[ 'description' ] ) ) {
                        $_SESSION[ 'type' ][ 'description' ] = $_POST[ 'description' ];
                    }

                    if ( isset( $errors ) ) {
                        return compact( 'view', 'page_title', 'page_description', 'errors' );
                    } else {
                        //update in DB
                        $type = $this -> model -> update( $typeId, $_SESSION[ 'type' ][ 'name' ], $_SESSION[ 'type' ][ 'description' ], date( 'Y-m-d' ) );

                        //redirect to author index
                        header( 'Location: ./index.php?ressource=type&action=view&id=' . $typeId );
                        die();
                    }
                } else {
                    $errors[ 'name' ] = 'Votre genre doit avoir au moins un nom valide.';
                }
            }
        }
    }
}
