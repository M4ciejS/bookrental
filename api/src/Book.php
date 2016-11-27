<?php

/*
 * Made by M4ciej
 */

/**
 * Description of Book
 *
 * @author m4ciej
 */
class Book implements JsonSerializable {

    private $id;
    private $title;
    private $author;
    private $description;

    public function __construct($title = "", $author = "", $description = "") {
        $this->id = -1;
        $this->title = $title;
        $this->author = $author;
        $this->description = $description;
    }

    public function jsonSerialize() {
        $result = array("id" => $this->id,
            "title" => $this->title,
            "author" => $this->author,
            "description" => $this->description);
        return $result;
    }

    function loadFromDB(Connection $connection, $id) {
        $result = $connection->query("SELECT * FROM books WHERE id=" . $id);
        if ($result->num_rows > 0) {
            $book = $result->fetch_assoc();
            $this->id = $book['id'];
            $this->setTitle($book['title']);
            $this->setAuthor($book['author']);
            $this->setDescription($book['description']);
            return true;
        } else {
            return false;
        }
    }

    public static function loadAll(Connection $connection) {
        $query = $connection->query("Select * FROM books");
        $result = array();
        foreach ($query as $book) {
            $b = new Book();
            $b->id = $book['id'];
            $b->setTitle($book['title']);
            $b->setAuthor($book['author']);
            $b->setDescription($book['description']);
            $result[] = $b;
        }
        return json_encode($result);
    }

    function create(Connection $conn) {
        if ($this->id == -1) {
            try {
                $conn->insertSql("books", array('title', 'author', 'description'), array($this->title, $this->author, $this->description));
                return true;
            } catch (Exception $e) {
                return false;
            }
        }else{
            return false;
        }
    }

    function update(Connection $conn, $title, $autor, $description) {
        
    }

    function deleteFromDB(Connection $conn) {
        $conn->deleteSql("books", $this->id);
    }

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getAuthor() {
        return $this->author;
    }

    function getDescription() {
        return $this->description;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAuthor($author) {
        $this->author = $author;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
