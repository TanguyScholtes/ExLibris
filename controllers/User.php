<?php

namespace Controllers;
use Models\User as UserModel;

class User extends Controller {

    protected $model = null;

    function __construct () {
        $this -> model = new UserModel();
    }

    public function connect() {
        $_SESSION[ 'email' ] = '';
        if ( !isset( $_SESSION[ 'userId' ] ) ) {
            $view = 'views/users/connect.php';
            $page_title = 'Se connecter';
            $page_description = 'Interface de connexion utilisateurs sur Ex Libris.';
            return compact( 'view', 'page_title', 'page_description' );
        } else {
            header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
            die();
        }
    }

    public function login () {
        if ( filter_var( $_POST[ 'email' ], FILTER_VALIDATE_EMAIL ) && isset( $_POST[ 'password' ] ) ) {
            $user = $this -> model -> getUser( $_POST[ 'email' ], sha1( $_POST[ 'password' ] ) );
            if ( $user ) {
                $_SESSION[ 'userId' ] = $user[ 'id' ];
                header("Location: ./index.php?ressource=book&action=index");
                die();
            } else {
                $view = 'views/users/connect.php';
                $_SESSION[ 'email' ] = $_POST[ 'email' ];
                $page_title = 'Se connecter';
                $page_description = 'Interface de connexion utilisateurs sur Ex Libris.';
                $errors[ 'password' ] = 'Identifiants invalides.';
                return compact( 'view', 'page_title', 'page_description', 'errors' );
            }
        } else {
            $view = 'views/users/connect.php';
            $page_title = 'Se connecter';
            $page_description = 'Interface de connexion utilisateurs sur Ex Libris.';
            if ( !empty( $_POST[ 'email' ] ) && isset( $_POST[ 'password' ] ) ) {
                $errors[ 'email' ] = $_POST[ 'email' ] . ' ne semble pas être une adresse email valide.';
                $_SESSION[ 'email' ] = $_POST[ 'email' ];
                return compact( 'view', 'page_title', 'page_description', 'errors' );
            } elseif ( empty( $_POST[ 'email' ] ) && !empty( $_POST[ 'password' ] ) ) {
                $_SESSION[ 'email' ] = '';
                $errors[ 'email' ] = 'Vous n\'avez pas entré d\'adresse email.';
                return compact( 'view', 'page_title', 'page_description', 'errors' );
            } else {
                $_SESSION[ 'email' ] = '';
                $errors[ 'email' ] = 'Vous n\'avez pas entré d\'adresse email.';
                $errors[ 'password' ] = 'Vous n\'avez pas entré de mot de passe.';
                return compact( 'view', 'page_title', 'page_description', 'errors' );
            }
        }
    }

    public function logout () {
        if ( $_SESSION[ 'userId' ] ) {
            if ( ini_get( "session.use_cookies" ) ) {
                $params = session_get_cookie_params();
                setcookie( session_name(), '', 1,
                    $params[ "path" ], $params[ "domain" ],
                    $params[ "secure" ], $params[ "httponly" ]
                );
            }
            session_destroy();
        }
        header("Location: " . $_SERVER[ 'HTTP_REFERER' ]);
        die();
    }
}
