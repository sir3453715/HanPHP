<?php

class Controller {

    function __construct() {
        //echo 'Main controller<br />';
        $this->view = new View();
        //echo get_class($this);
        if(get_class($this) != 'Error'){
            //require __SERVER_ROOT_DOC.DIRECTORY_SEPARATOR.'models/public_model.php';
            //$this->public_model = new Public_Model();   
        }
       
    }
    
    /**
     * 
     * @param string $name Name of the model
     * @param string $path Location of the models
     */
    public function loadModel($name, $modelPath = 'models/') {
        
        $path = __SERVER_ROOT_DOC.DIRECTORY_SEPARATOR.$modelPath . $name.'_model.php';
        //echo $path.'123';
        //exit;
        if (file_exists($path)) {
            //echo $name.'456';
            //exit;            
            require __SERVER_ROOT_DOC.DIRECTORY_SEPARATOR.$modelPath .$name.'_model.php';  
            $modelName = $name . '_Model';
            $this->model = new $modelName();

        }   
           
    }

}