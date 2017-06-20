<?php

namespace Models;

class Type extends Model {
    public function getAllTypes () {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM genres
                        ORDER BY name';
                $pdoStmnt = $this -> connectDB -> query( $sql );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getType ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM genres WHERE id = :id';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':id' => $id ] );

                return $pdoStmnt -> fetch();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function save ( $name, $description ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'INSERT INTO genres ( `id`,
        									`name`,
        									`description`,
                                            `created_at`,
                                            `updated_at` )
        				VALUES ( NULL ,
        						:name,
        						:description,
        						CURRENT_TIMESTAMP,
        						CURRENT_TIMESTAMP )';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':name' => $name,
                    ':description' => $description
                ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function deleteType ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'DELETE FROM genres
                        WHERE id = :genreId';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':genreId' => $id ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function update ( $id, $name, $description, $timestamp ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'UPDATE genres
                        SET name = :name,
        					description = :description,
        					updated_at = :updated_at
        				WHERE id = :id';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':id' => $id,
                    ':name' => $name,
                    ':description' => $description,
                    ':updated_at' => $timestamp
                ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

}
