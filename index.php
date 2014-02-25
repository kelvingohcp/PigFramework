<?php
    // change this to false if the app is in production
    define('IS_DEVELOPING', true);    

    // only show error messages while developing
    if (IS_DEVELOPING){
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);
        error_reporting(E_ALL);
    }
   
    define('BASEPATH', __DIR__);

    $action = basename($_SERVER['REQUEST_URI']);

    
    if ( $action === ''){
        $action = 'index';
    }

    call_user_func($action);
    
    function index(){
        $file_name = __FUNCTION__ . '.php';
        
        $file_path = BASEPATH . '/view/' . $file_name;
        // $output = file_get_contents($file_name);

        echo fetch($file_path);      
    }
    
    function service(){
        $file_name = __FUNCTION__ . '.php';
        
        $file_path = BASEPATH . '/view/' . $file_name;
        // $output = file_get_contents($file_name);

        echo fetch($file_path);      
    }    
    
    function contact(){
        $file_name = __FUNCTION__ . '.php';
        
        $file_path = BASEPATH . '/view/' . $file_name;
        // $output = file_get_contents($file_name);

        echo fetch($file_path);      
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

        $file_name = __FUNCTION__ . '.php';
        
        $file_path = BASEPATH . '/view/' . $file_name;
        // $output = file_get_contents($file_name);

        echo fetch($file_path, $data);      
    }


    function fetch($file_path = null, $data = [], $layout = 'normal') {
        ob_start();
        extract($data);
        require($file_path);
        $main = ob_get_contents();
        ob_end_clean();                // End buffering and discard
        
        ob_start();
        $layout_file_name = BASEPATH . '/view/layout/' . $layout . '.php';
        require($layout_file_name);                // Include the file
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
        return $contents;              // Return the contents
        
        /*
        ob_start();                    // Start output buffering
        $content = file_get_contents($file_path);
        
        
        $layout_file_name = BASEPATH . '/view/layout/' . $layout . '.php';
        require($layout_file_name);                // Include the file
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
        return $contents;              // Return the contents
        */
    }
