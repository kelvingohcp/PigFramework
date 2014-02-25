<?php
class PigController{
    static $current_method = null;
    function __construct($method_name){
        self::$current_method = $method_name;
    }
    
    function render($file_path = '', $data = []){
        $file_name = self::$current_method  . '.php';
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
