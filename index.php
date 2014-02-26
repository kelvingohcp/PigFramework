<?php
/* TODO:
 * make model works in the framework
 * 
 * PRINCIPLE:
 * if you need something like dictionary, use stdClass rather than associative array
 * I dont like fucking associative array. array should be fucking array
        $book = (object) array(
        "name" => "Harry Potter and the Prisoner of Azkaban",
        "author" => "J. K. Rowling",
        "publisher" => "Arthur A. Levine Books",
        "amazon_link" => "http://www.amazon.com/dp/0439136369/"
        );
   
   convention over configuration.
   dont configure anything. 
*/
 
class PigFramework{
    private $current_controller = null;
    private $current_method = null;
    private $default_controller = 'example';
    private $default_method = 'index';

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
    
    function run(){
        $url_segments = explode('/', $_SERVER['REQUEST_URI']);
        if (count($url_segments) == 4){
            $controller_name = $url_segments[2];
            $method_name = $url_segments[3];              
        }
        else if (count($url_segments) == 3){
            $controller_name = $url_segments[2];
            $method_name = $this->default_method;
        }
        else if (count($url_segments) == 2){
            $controller_name = $this->default_controller;
            $method_name = $this->default_method;
        }
                
        $this->current_controller = $controller_name;
        $this->current_method = $method_name;

        require BASEPATH . '/controller/pig_controller.php';
        require BASEPATH . '/controller/' . $controller_name . '.php';
        
        $class_name = ucfirst($controller_name);
        $controller = new $class_name($method_name);
  
        call_user_func( array( $controller, $method_name ) );      
    }

    function enable_production_mode(){
        // actually, I don't know how to set them ..
        // figure it out sometime ;)        
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);
        error_reporting(E_ALL);
    }
}


$pig = new PigFramework;
# $pig->enable_production_mode();
$pig->run();
