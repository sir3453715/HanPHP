<?php

class Bootstrap {

    private $_url = null;
    private $_controller = null;
    
    private $_controllerPath = 'controllers/'; // Always include trailing slash
    private $_modelPath = 'models/'; // Always include trailing slash
    public $_viewPath = 'views/'; // Always include trailing slash
    private $_errorFile = 'controllers/errorpage.php';
    public $_assetPath = '';
    private $_defaultFile = 'index.php';
    function __construct(){
        $domain = $_SERVER['HTTP_HOST'];
        if(count(explode('www.2way.cloud',$domain))>1){
            Func::go_to('./www');
            exit;
        }
        //echo $domain;
        //echo ((preg_match('/^2way.cloud/',$domain,$reg))?1:0);
        //exit;
        if(preg_match('/^2way.cloud/',$domain,$reg)){
            Func::go_to('http://www.2way.cloud/www');
            exit;
        }
        //echo $domain;
        //查網域
        $db = new Database();
        if(!$data = $db->Execute("select * from member where domain='$domain' and status='1'")){
            $this->_error();
            exit;
        }
        $module_id = $data[0]['module_id'];
        Session::set('member_id',$data[0]['id'],'client');
        //print_r($data);
        //echo "select * from modules where id='".$data[0]['modules_id']."'";
        //exit;
        $strSQL = "select * from modules where id='$module_id'";
        //echo $strSQL.PHP_EOL;
        $data = $db->Execute($strSQL);
        //echo "select * from modules where id='".$module_id."'";
        //print_r($data);
        //exit;
        $this->_controllerPath = 'controllers/' . $data[0]['folder'] . '/';
        $this->_modelPath = 'models/' . $data[0]['folder'] . '/';
        $this->_assetPath = '/assets/' .$data[0]['folder'] . '/';
        $this->_viewPath = 'views/' .$data[0]['folder'] . '/';
        //echo $this->_viewPath;
        //exit;
        //$this->_controllerPath = 'controllers/' . $data[0]['folder'] . '/';                
        //print_r($data);
    }    
    /**
     * Starts the Bootstrap
     * 
     * @return boolean
     */
    public function init()
    {
        // Sets the protected $_url
        $this->_getUrl();
        //print_r($this->_url);
        
        // Load the default controller if no URL is set
        // eg: Visit http://localhost it loads Default Controller
        
        if (empty($this->_url[0])) {
            //$this->_loadDefaultController();
            //return false;
            $this->_url[0] = 'index';
        }
        //echo 123;
        //exit;
        $this->_loadExistingController();
        //$this->_loadPublicModel();
        $this->_callControllerMethod();
    }
    
    /**
     * (Optional) Set a custom path to controllers
     * @param string $path
     */
    public function setControllerPath($path)
    {
        $this->_controllerPath = trim($path, '/') . '/';
    }
    
    /**
     * (Optional) Set a custom path to models
     * @param string $path
     */
    public function setModelPath($path)
    {
        $this->_modelPath = trim($path, '/') . '/';
    }
    
    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: error.php
     */
    public function setErrorFile($path)
    {
        $this->_errorFile = trim($path, '/');
    }
    
    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: index.php
     */
    public function setDefaultFile($path)
    {
        $this->_defaultFile = trim($path, '/');
    }
    
    /**
     * Fetches the $_GET from 'url'
     */
    private function _getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }
    
    /**
     * This loads if there is no GET parameter passed
     */
    private function _loadDefaultController()
    {
        require $this->_controllerPath . $this->_defaultFile;
        $this->_controller = new Index();
        $this->_controller->index();
    }
    
    /**
     * Load an existing controller if there IS a GET parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingController()
    {
        $file = $this->_controllerPath . $this->_url[0] . '.php';
        //echo $this->_url[0];
        //exit;
        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[0];
            $this->_controller->loadModel($this->_url[0], $this->_modelPath);
        } else {
            $this->_error();
            return false;
        }
    }
    /**
     * If a method is passed in the GET url paremter
     * 
     *  http://localhost/controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    private function _callControllerMethod()
    {
        $length = count($this->_url);
        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
            }
        }
        
        // Determine what to load
        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            
            case 4:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            
            case 3:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            
            case 2:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}();
                break;
            
            default:
                $this->_controller->index();
                break;
        }
    }
    
    /**
     * Display an error page if nothing exists
     * 
     * @return boolean
     */
    private function _error() {
        //echo $this->_controllerPath . $this->_errorFile;
        //exit;
        //require $this->_controllerPath . $this->_errorFile;
        require $this->_errorFile;
        $this->_controller = new ErrorPage();
        $this->_controller->index();
        exit;
    }

}
