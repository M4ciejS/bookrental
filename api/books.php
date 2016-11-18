<?php

require_once './src/bootstrap.php';
/*
 * Made by M4ciej
 */
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        //header('Content-type: application/json');
        $book = new Book();
        $book->loadFromDB($connection, $_GET['id']);
        echo json_encode($book);
        
    } else {
        header('Content-type: application/json');
        $books = Book::loadAll($connection);
        echo $books;
    }
}
