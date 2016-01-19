<?php
/* TODO:
 * make model works in the framework
 * 
*/

class PigController{
    static $current_method = null;
    function __construct($method_name){
        self::$current_method = $method_name;
    }
    
    function render($file_path = '', $data = [], $layout='default'){
        $file_name = self::$current_method  . '.php';
        $file_path = BASEPATH . '/view/' . lcfirst(get_called_class() ) . '/' . $file_name;
        echo $this->fetch($file_path, $data, $layout);      
        
    }


    function fetch($file_path = null, $data = [], $layout = 'default') {
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
    }  
    
    
}

class PigModel{
    function __construct__(){
        require_once BASEPATH . '/library/rb.php';
    }
}
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
        //    $controller_name = $url_segments[2];
            $controller_name = $default_controller
            $method_name = $this->default_method;
        }
        else if (count($url_segments) == 2){
            $controller_name = $this->default_controller;
            $method_name = $this->default_method;
        }
                
        $this->current_controller = $controller_name;
        $this->current_method = $method_name;

        require BASEPATH . '/controller/' . $controller_name . '.php';
        
        $class_name = ucfirst($controller_name);
        $controller = new $class_name($method_name);
  
        call_user_func( array( $controller, $method_name ) );      
    }

}

$pig = new PigFramework;
# $pig->enable_production_mode();
$pig->run();
