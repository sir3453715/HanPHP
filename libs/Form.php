<?php
/**
 *
 * - Fill out a form
 *    - POST to PHP
 *  - Sanitize
 *  - Validate
 *  - Return Data
 *  - Write to Database
 
 */
class Form
{
    
    /** @var array $_currentItem The immediately posted item*/
    private $_formString = '';
    
    /** @var array $_postData Stores the Posted Data */
    private $_postData = array();
    
    /** @var object $_val The validator object */
    private $_val = array();
    
    /** @var array $_error Holds the current forms errors */
    private $_error = array();
    
    /**
     * __construct - Instantiates the validator class
     * 
     */
    public function __construct() 
    {
        //$this->_val = new Val();
    }
    
    /**
     * post - This is to run $_POST
     * 
     * @param string $field - The HTML fieldname to post
     */
    public static function init($arr)
    {
        //print_r($arr);
        //exit;
        self::makeFormString($arr);
    }
    
    private static function makeTableString($arr){
        echo '<table border="1" cellspacing="2" cellpadding="4">';
        if(is_array($arr['elements'])){

            foreach($arr['elements'] as $kk=>$vv){
                //echo dirname(__FILE__)."/elements/".$vv['type'].".php".'<br />';
                if(file_exists(dirname(__FILE__)."/elements/".$vv['type'].".php")){
                    //echo dirname(__FILE__)."/elements/".$vv['type'].".php".'<br />';
                    require(dirname(__FILE__)."/elements/".$vv['type'].".php");
                }
            }
            echo '
            <tr>
                <td bgcolor="#BBBBBB" colspan="4" align="center">
                    <INPUT TYPE="hidden" name="flag" value="true">
                    <input type="button" name="status2" value="送出" onclick="chkdata()">
                </td>
            </tr>';
            
        }
        echo '</table>';        
    }
    private static function makeFormString($arr){
        echo '<form name="'.$arr['form_name'].'" id="'.$arr['form_name'].'" method="post" enctype="multipart/form-data"><input type="hidden" name="flag" value="true" />';
        self::makeTableString($arr);
        echo '</form>';
    }
}