<?php
/*
 * TODO:
 * implement controller with class, singleton
 * 
 * e.g, 
 * class Example extend PigController{
 *     function greeting(){
 *         $this->render();
 *     }
 *     function intro(){
 *         $this->render();
 *     }
 * }
 * ------------------------------------------------------------------
 * 
class PigController{
    static $current_action = null;
    function __construct(){
        $current_action = 'the_action';
    }
}

class PigFramework(){
    static $current_controller = null;
    function __construct(){
        $current_controller = 'the_controller';
    }
}

*/
 
class PigFramework{
    private $current_action = null;
    
    function run(){
        $action = basename($_SERVER['REQUEST_URI']);

        if ( $action === ''){
            $action = 'index';
        }
        
        $this->current_action = $action;

       call_user_func( array( $this, $action ) );      
    }
    
    function __construct(){
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
    }
    
    function enable_production_mode(){
        // actually, I don't know how to set them ..
        // figure it out sometime ;)        
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);
        error_reporting(E_ALL);
    }
    

    function index(){
        $this->render();
    }
    
    function service(){
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
    
    function render($file_path = '', $data = []){
        $file_name = $this->current_action  . '.php';
        $file_path = BASEPATH . '/view/' . $file_name;
        echo $this->fetch($file_path, $data);      
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
  
}


$pig = new PigFramework;
# $pig->enable_production_mode();
$pig->run();
