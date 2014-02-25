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


class PigFramework(){
    static $current_controller = null;
    function __construct(){
        $current_controller = 'the_controller';
    }
}

*/
 
class PigFramework{
    private $current_controller = null;
    private $current_method = null;

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
        # $action = basename($_SERVER['REQUEST_URI']);
        $url_segments = explode('/', $_SERVER['REQUEST_URI']);
        $controller_name = $url_segments[2];
        $method_name = $url_segments[3];

        if ( $method_name === ''){
            $method_name = 'index';
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
