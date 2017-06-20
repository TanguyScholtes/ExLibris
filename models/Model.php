<?php

namespace Models;

class Model {

    protected $connectDB = null;

    function __construct () {
        $dbConfig = parse_ini_file( DB_INI_FILE );

        $pdoDsn = $dbConfig[ 'driver' ] . ':dbname=' . $dbConfig[ 'dbname' ] . ';host=' . $dbConfig[ 'host' ];
        $pdoUsername = $dbConfig[ 'username' ];
        $pdoPassword = $dbConfig[ 'password' ];
        $pdoOptions = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this -> connectDB = new \PDO( $pdoDsn, $pdoUsername, $pdoPassword, $pdoOptions );
            $this -> connectDB -> exec( 'SET CHARACTER SET UTF8' );
            $this -> connectDB -> exec( 'SET NAMES UTF8' );
        } catch ( \PDOException $e ) {
            die( $e -> getMessage() );
        }
    }
}
