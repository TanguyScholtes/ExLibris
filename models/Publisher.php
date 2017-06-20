<?php

namespace Models;

class Publisher extends Model {
    public function getAllPublishers () {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM editors
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

    public function getPublisher ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM editors WHERE id = :id';
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

    public function save ( $name, $website, $logo, $description ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'INSERT INTO editors ( `id`,
        									`name`,
        									`website`,
                                            `logo`,
        									`description`,
                                            `created_at`,
                                            `updated_at` )
        				VALUES ( NULL ,
        						:name,
        						:website,
                                :logo,
        						:description,
        						CURRENT_TIMESTAMP,
        						CURRENT_TIMESTAMP )';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':name' => $name,
                    ':website' => $website,
                    ':logo' => $logo,
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

    public function deletePublisher ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'DELETE FROM editors
                        WHERE id = :editorId';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':editorId' => $id ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function update ( $id, $name, $website, $logo, $description, $timestamp ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'UPDATE editors
                        SET name = :name,
                            website = :website,
                            logo = :logo,
        					description = :description,
        					updated_at = :updated_at
        				WHERE id = :id';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':id' => $id,
                    ':name' => $name,
                    ':website' => $website,
                    ':logo' => $logo,
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
