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

    $file_name = basename($_SERVER['REQUEST_URI']) . '.php';
    
    if ( $file_name === '.php'){
        $file_name = 'index.php';
    }
    
    $file_path = BASEPATH . '/view/' . $file_name;
    // $output = file_get_contents($file_name);

    echo fetch($file_path);

    function fetch($file_path = null, $layout = 'normal') {
        ob_start();                    // Start output buffering
        $content = file_get_contents($file_path);
        $layout_file_name = BASEPATH . '/view/layout/' . $layout . '.php';
        require($layout_file_name);                // Include the file
        $contents = ob_get_contents(); // Get the contents of the buffer
        ob_end_clean();                // End buffering and discard
        return $contents;              // Return the contents
    }
