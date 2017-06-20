<?php

namespace Models;

class Author extends Model {
    public function getAllAuthors () {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM authors
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

    public function getAuthor ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM authors WHERE id = :id';
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

    public function getAuthorsByBookId ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT authors.* FROM authors
                        JOIN author_book ON authors.id = author_book.author_id
                        JOIN books ON author_book.book_id = books.id
                        WHERE books.id = :id
                        ORDER BY authors.name';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':id' => $id ] );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getAuthorsByPublisherId ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT DISTINCT authors.* FROM authors
                        JOIN author_book ON authors.id = author_book.author_id
                        JOIN books ON author_book.book_id = books.id
                        JOIN editors ON books.editor_id = editors.id
                        WHERE editors.id = :id
                        ORDER BY authors.name';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':id' => $id ] );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getAuthorsByTypeId ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT DISTINCT authors.* FROM authors
                        JOIN author_book ON authors.id = author_book.author_id
                        JOIN books ON author_book.book_id = books.id
                        JOIN genres ON books.genre_id = genres.id
                        WHERE genres.id = :id
                        ORDER BY authors.name';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':id' => $id ] );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function deleteAuthor( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'DELETE FROM authors
                        WHERE id = :authorId';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':authorId' => $id ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function save ( $name, $first_name, $photo, $datebirth, $datedeath, $bio ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'INSERT INTO authors ( `id`,
        									`name`,
        									`first_name`,
                                            `photo`,
        									`datebirth`,
        									`datedeath`,
        									`bio`,
                                            `created_at`,
                                            `updated_at` )
        				VALUES ( NULL ,
        						:name,
        						:first_name,
                                :photo,
        						:datebirth,
        						:datedeath,
        						:bio,
        						CURRENT_TIMESTAMP,
        						CURRENT_TIMESTAMP )';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':name' => $name,
                    ':first_name' => $first_name,
                    ':photo' => $photo,
                    ':datebirth' => $datebirth -> date,
                    ':datedeath' => $datedeath -> date,
                    ':bio' => $bio
                ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function update ( $id, $name, $first_name, $photo, $datebirth, $datedeath, $bio, $timestamp ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'UPDATE authors
                        SET name = :name,
                            first_name = :first_name,
                            photo = :photo,
        					datebirth = :datebirth,
        					datedeath = :datedeath,
        					bio = :bio,
        					updated_at = :updated_at
        				WHERE id = :id';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':id' => $id,
                    ':name' => $name,
                    ':first_name' => $first_name,
                    ':photo' => $photo,
                    ':datebirth' => $datebirth,
                    ':datedeath' => $datedeath,
                    ':bio' => $bio,
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
