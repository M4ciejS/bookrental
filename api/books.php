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
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['title'])&&
            isset($_POST['author'])&&
            isset($_POST['description'])) {
        $book=new Book($_POST['title'],$_POST['author'],$_POST['description']);
        if($book->create($connection)){
            echo "Udało się!";
        }else{
            echo "Nie udało się!";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    $vars=[];
    parse_str(file_get_contents('php://input'), $vars);
    //var_dump($vars);
    $book=new Book();
    $book->loadFromDB($connection, $vars['id']);
    var_dump($book);
    $book->deleteFromDB($connection);
}
