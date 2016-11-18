<?php

/*
 * Made by M4ciej
 */

/**
 * Description of Book
 *
 * @author m4ciej
 */
class Book implements JsonSerializable{

    private $id;
    private $title;
    private $author;
    private $date;

    public function __construct() {
        $this->id = -1;
        $this->title = "";
        $this->author = "";
        $this->date = "";
    }

    public function jsonSerialize() {
        $result=array("id"=>$this->id,
            "title"=>$this->title,
            "author"=>$this->author,
            "date"=>$this->date);
        return $result;
    }
    function loadFromDB(Connection $connection, $id) {
        $result=$connection->query("SELECT * FROM books WHERE id=".$id);
        if($result->num_rows>0){
            $book=$result->fetch_assoc();
            $this->id=$book['id'];
            $this->setTitle($book['title']);
            $this->setAuthor($book['author']);
            $this->setDate($book['date']);
            return true;
        }else{
            return false;
        }
    }

    public static function loadAll(Connection $connection) {
        $query = $connection->query("Select * FROM books");
        $result = array();
        foreach ($query as $book) {
            $b = new Book();
            $b->id=$book['id'];
            $b->setTitle($book['title']);
            $b->setAuthor($book['author']);
            $b->setDate($book['date']);
            //region Extra reflection
            /*$reflectionClass = new ReflectionClass($b);
            $reflectionProperty = $reflectionClass->getProperty('id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($b, $book['id']);*/
            //endregion
            $result[]= $b;
            
        }
        //return json_encode($result);
        return json_encode($result);
    }

    function create($conn, $name, $autor) {
        
    }

    function update($conn, $name, $autor) {
        
    }

    function delteFromDB($conn) {
        
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

    function getDate() {
        return $this->date;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setAuthor($author) {
        $this->author = $author;
    }

    function setDate($date) {
        $this->date = $date;
    }

}
