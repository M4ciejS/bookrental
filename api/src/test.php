<?php
/* 
 * Made by M4ciej
 */
require_once 'bootstrap.php';
var_dump($connection->query("Select * From books"));
$b1=new Book("nana","Jarek","2016-10-02");
var_dump($b1);

