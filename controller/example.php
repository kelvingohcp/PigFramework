<?php

class Example extends PigController{
    function index(){
        $this->render();
    }
    
    function product(){
        $array = array(
        "name" => "Harry Potter and the Prisoner of Azkaban",
        "author" => "J. K. Rowling",
        "publisher" => "Arthur A. Levine Books",
        "amazon_link" => "http://www.amazon.com/dp/0439136369/"
        );
         
        $book = (object) $array;

        $array2 = array(
        "name" => "SEX CITY",
        "author" => "J. K. Rowling",
        "publisher" => "Arthur A. Levine Books",
        "amazon_link" => "http://www.amazon.com/dp/0439136369/"
        );
         
        $book2 = (object) $array2;
        
        $books = array($book, $book2);
        
        $data = array('books'=>$books);

        $this->render('', $data);
    }
    
    function contact(){
        $this->render();
    }
    function intro(){
        $this->render();
    }

  
}
