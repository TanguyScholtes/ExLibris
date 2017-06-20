<?php

namespace Models;

class Book extends Model {

    public function getAllBooks () {
        /* --- Get every book in the database and their full informations ---*/
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM books
                        ORDER BY title';
                $pdoStmnt = $this -> connectDB -> query( $sql );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getLastBooks () {
        /* --- Get 5 latest created books --- */
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM books
                        ORDER BY created_at DESC
                        limit 5';
                $pdoStmnt = $this -> connectDB -> query( $sql );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getBook ( $id ) {
        /* --- Get a single book matching the given ID and its full informations --- */
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM books WHERE id = :id';
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

    public function save ( $title, $front_cover, $summary, $isbn, $npages, $datepub, $language_id, $genre_id, $location_id, $editor_id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'INSERT INTO books (	`id` ,
        									`title` ,
        									`front_cover` ,
        									`summary` ,
        									`isbn` ,
        									`npages` ,
        									`datepub` ,
        									`language_id` ,
        									`genre_id` ,
        									`location_id` ,
        									`editor_id` ,
        									`created_at` ,
        									`updated_at` )
        				VALUES ( NULL ,
        						:title,
        						:front_cover,
        						:summary,
        						:isbn,
        						:npages,
        						:datepub,
        						:language_id,
        						:genre_id,
        						:location_id,
        						:editor_id,
        						CURRENT_TIMESTAMP ,
        						CURRENT_TIMESTAMP )';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':title' => $title,
                    ':front_cover' => $front_cover,
                    ':summary' => $summary,
                    ':isbn' => $isbn,
                    ':npages' => $npages,
                    ':datepub' => $datepub -> date,
                    ':language_id' => $language_id,
                    ':genre_id' => $genre_id,
                    ':location_id' => $location_id,
                    ':editor_id' => $editor_id
                ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function update ( $id, $title, $front_cover, $summary, $isbn, $npages, $datepub, $language_id, $genre_id, $location_id, $editor_id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'UPDATE books
                        SET title = :title,
                            front_cover = :front_cover,
        					summary = :summary,
        					isbn = :isbn,
        					npages = :npages,
        					datepub = :datepub,
        					language_id = :language_id,
        					genre_id = :genre_id,
        					location_id = :location_id,
        					editor_id = :editor_id,
        					updated_at = :updated_at
        				WHERE id = :id';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':id' => $id,
                    ':title' => $title,
                    ':front_cover' => $front_cover,
                    ':summary' => $summary,
                    ':isbn' => $isbn,
                    ':npages' => $npages,
                    ':datepub' => $datepub -> date,
                    ':language_id' => $language_id,
                    ':genre_id' => $genre_id,
                    ':location_id' => $location_id,
                    ':editor_id' => $editor_id,
                    ':updated_at' => date('Y-m-d')
                ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function deleteBook ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'DELETE FROM books
                        WHERE id = :bookId';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':bookId' => $id ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getBooksByAuthorId ( $id ) {
        /* --- Get all the books writen by the author matching the given ID and their full informations --- */
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT books.* FROM books
                        JOIN author_book ON books.id = author_book.book_id
                        JOIN authors ON author_book.author_id = authors.id
                        WHERE authors.id = :id
                        ORDER BY books.title';
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

    public function getOtherBooksFromAuthor ( $bookId, $authorId ) {
        /* --- Get all books writen by the author matching the given Author ID and their full informations except the one matching the given Book ID --- */
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT books.title, books.id FROM books
                        JOIN author_book ON books.id = author_book.book_id
                        JOIN authors ON author_book.author_id = authors.id
                        WHERE authors.id = :authorId
                        AND books.id != :bookId
                        ORDER BY books.title';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [
                    ':authorId' => $authorId,
                    ':bookId' => $bookId
                ] );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getBooksByPublisherId( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT books.* FROM books
                        JOIN editors ON books.editor_id = editors.id
                        WHERE editors.id = :id
                        ORDER BY books.title';
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

    public function getBooksByTypeId( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT books.* FROM books
                        JOIN genres ON books.genre_id = genres.id
                        WHERE genres.id = :id
                        ORDER BY books.title';
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

    public function getAllLanguages () {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM languages
                        ORDER BY full_name';
                $pdoStmnt = $this -> connectDB -> query( $sql );

                return $pdoStmnt -> fetchAll();
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
    }

    public function getLanguage ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM languages WHERE id = :id';
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

    public function getAllLocations () {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM locations
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

    public function getLocation ( $id ) {
        if ( $this -> connectDB ) {
            try {
                $sql = 'SELECT * FROM locations WHERE id = :id';
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

    public function attachAuthors( $book_id, $author_id )
	{
        if ( $this -> connectDB ) {
            try {
                $sql = 'INSERT INTO author_book (author_id, book_id)
                        VALUES (:author_id, :book_id)';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':author_id' => $author_id, ':book_id' => $book_id ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
	}

	function detachAuthors( $book_id, $author_id )
	{
        if ( $this -> connectDB ) {
            try {
                $sql = 'DELETE FROM author_book WHERE author_id=:author_id AND book_id=:book_id';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':author_id' => $author_id, ':book_id' => $book_id ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
	}

	function resetAuthors( $book_id )
	{
        if ( $this -> connectDB ) {
            try {
                $sql = 'DELETE FROM author_book WHERE book_id=:book_id';
                $pdoStmnt = $this -> connectDB -> prepare( $sql );
                $pdoStmnt -> execute( [ ':book_id' => $book_id ] );

                return true;
            } catch ( \PDOException $e ) {
                return $e -> getMessage();
            }
        } else {
            return false;
        }
	}

}
