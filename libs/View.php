<?php
class View {
    public $_include_flag;
    private $_assetPath;
    private $_viewPath;
    function __construct() {
        //echo 'this is the view';
            //print_r($this->_include_flag);
            //require 'views/html_header.php';  
            //require 'views/html_start.php';
        global $bootstrap;
        $this->_assetPath = $bootstrap->_assetPath;
        $this->_viewPath = $bootstrap->_viewPath;
    }

    public function render($name, $type = 'normal')
    {
        //global $bootstrap;
        //echo $bootstrap;
        //exit;
        //$this->_include_flag = $noInclude;
        //print_r($this->_include_flag);

        //echo $this->_viewPath;
        //exit;
        switch($type){
            case "":
            break;
            default:
                //require 'views/html_header.php';  
                //require 'views/html_start.php';        
                //require 'views/' . $name . '.php';    
                //require __SERVER_ROOT_DOC.'/views/html_end.php';
                if(file_exists($this->_viewPath . $name . '.php')){
                    require $this->_viewPath . $name . '.php'; 
                }else{
                    require 'views/error/index.php';  
                }    
                         
        }

    }
    function __destruct(){
	 //echo 'this is the view';
    	//echo __DIR__;
    	//require __SERVER_ROOT_DOC.'/views/html_end.php';  
    }

}