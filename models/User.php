<?php

namespace Models;

class User extends Model {

    public function getUser ( $email, $password ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM users
                        WHERE email = :email
                        AND password = :password';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':email' => $email,
                    ':password' => $password
                 ] );

                return $pdoStmnt -> fetch();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }
}
