<?php

class Pig_admin extends PigController{
    function index(){
        $this->render('',[],'pig_admin');
    }
    function scaffold(){
        $component_name = $_POST['component_name'];

        /*
        $content = "some text here";
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.txt","wb");
        fwrite($fp,$content);
        fclose($fp);
        */
        $file = BASEPATH . '/controller/' . $component_name . '.php';
        $buffer = 'my new line here';
        $template = BASEPATH .'/pig_admin_component/controller.php';
        if (file_exists( $template )) {
                $buffer = file_get_contents($template) . "\n" . $buffer;
        }

        $success = file_put_contents($file, $buffer);

        echo $component_name;
    }
}
