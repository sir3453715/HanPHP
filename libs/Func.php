<?php
class Func
{
    
    public static function go_to($go)
    {
        if($go==1 || $go == -1)
        echo '<script language="javascript">
        var u = navigator.userAgent;
        if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/) && /(Safari)/i.test(u)){
           window.location.href = window.document.referrer;
        }else{
            window.history.go('.$go.');
        }
        </script>';
        else
        echo '<script language="javascript">window.location=("'.$go.'")</script>';
        exit;
    }

    public static function p_go_to($go)
    {
        echo '<script language="javascript">window.parent.location=("'.$go.'")</script>';
        exit;
    }
    public static function msg_box($msg)
    {
        if ($msg != ""){
            echo '<meta charset="UTF-8"><script language="javascript">alert("'.$msg.'")</script>';
        }
    }
    public static function set($key, $value,$target='client')
    {
        $_SESSION[$target][$key] = $value;
    }
    
    public static function get($key,$target='client')
    {
        if (isset($_SESSION[$target][$key]))
        return $_SESSION[$target][$key];
    }
    
    public static function destroy($target='client')
    {
        unset($_SESSION[$target]);
        $_SESSION[$target] = null;
        //@session_destroy();
    }

    public static function GetMenuData($filename){
        global $db;
        $menu_path  =   basename($filename);
        //echo $menu_path;
        //echo 123;
        //print_r($)
        //exit;

        $strSQL ="select * from menu_detail where func_page='{$menu_path}'";
        //echo $strSQL;
        //exit;
        $rs = $db->Execute($strSQL);
        if (!$rs) {

            return 0;
        }else{
            $now_menu['id'] = $rs[0]['id'];
            $strSQL ="select * from menu_detail where id='".$now_menu['id']."'";
            // echo $strSQL;
            // exit;
            $rs1 = $db->Execute($strSQL);
            $strSQL ="select * from menu_detail where up_id='".$rs1[0]['up_id']."'";
            // echo $strSQL;
            // exit;
            $rs2 = $db->Execute($strSQL);
            $ii=0;
            foreach ($rs2 as $value) {
                $tmp[$ii] = $value['id'];
                $ii++;
            }
            $now_menu['sub_menu'] = $rs1[0]['menu_name'];
            $now_menu['sub_menu_id'] = $tmp;
            // print_r($tmp);
            // exit;
            $now_menu['menu_name'] = $rs[0]['icon'];
            $now_menu['menu_name'] = $rs[0]['menu_name'];
            $now_menu['func_page'] = basename($filename, '.php');
            return $now_menu;
        }
    }
    //權限用
    public static function MakeMenu($arr_menu){
        global $now_menu;
        $now_menu_id =$now_menu['id'];
        if (is_array($arr_menu))
        {
            foreach ($arr_menu as $kk => $vv) {
                //是否有SUB MENU
                if(is_array($vv['sub_menu'])) {
                    if (in_array($now_menu_id,$vv['sub_menu_id'])) {
                        echo '<li class="active">';
                    }else{
                       echo '<li>';
                    }        
                    echo '<a class="has-arrow" href="#" aria-expanded="false"><i class="fa fa-'.$vv['icon'].'"></i><span class="hide-menu">'.$vv['menu_name'].'</span></a>';          
                    echo '<ul aria-expanded="false" class="collapse">';
                    foreach ($vv['sub_menu'] as $kkk => $vvv) {
                        if($vvv['is_blank'] == '1'){
                            $is_blank = 'target="_blank"';
                        }else{
                            $is_blank = '';
                        }
                        if ($now_menu_id == $vvv['id']) {

                            echo '<li><a href="'.$vvv['func_page'].'" '.$is_blank.'>'.$vvv['menu_name'].'</a></li>';
                            $now_menu['path'] = $vv['menu_name'].' > '.$vvv['menu_name'];
                        }else{
                            echo '<li><a href="'.$vvv['func_page'].'" '.$is_blank.'>'.$vvv['menu_name'].'</a></li>';    
                        }
                        
                    }
                    echo '</ul>';
                    echo '</li>';
                }else{
                    if (in_array($now_menu_id,$vv['sub_menu_id'])) {
                        echo '<li class="active" style="margin-left: 28px;">';
                    }else{
                       echo '<li style="margin-left: 28px;">';
                    }        
                    // echo '<a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-'.$vv['icon'].'"></i><span class="hide-menu">'.$vv['menu_name'].'</span></a>';          
                    // echo '<ul aria-expanded="false" class="collapse">';
                    if($vv['is_blank'] == '1'){
                            $is_blank = 'target="_blank"';
                    }else{
                            $is_blank = '';
                    }
                    if($now_menu_id == $vv['id']){
                         echo '<a href="'.$vv['func_page'].'" '.$is_blank.'>'.$vv['menu_name'].'</a>';
                        $now_menu['path'] = $vv['module_menu'];
                    }else{
                        echo '<a href="'.$vv['func_page'].'" '.$is_blank.'>'.$vv['menu_name'].'</a>';
                    }
                    // echo '</ul>';
                    echo '</li>';
                }
            }
        }        
    }
    //不需權限用
    public static function MakeMenu_n($arr_menu){
        global $now_menu;
        global $db;
        $now_menu_id =$now_menu['id'];
        if (is_array($arr_menu))
        {
            foreach ($arr_menu as $kk => $vv) {
                //是否有SUB MENU
                $strSQL ="select * from menu_detail where up_id='".$vv['id']."'";
                $rs = $db->Execute($strSQL);
                if($rs[0]['id']!='') {
                    echo '<li role="presentation" data-toggle="collapse" data-target="#sb-'.$vv['id'].'">';
                    echo '<a href="#"><span class="glyphicon glyphicon-'.$vv['icon'].'"></span> '.$vv['menu_name'].'</a>';
                    echo '<ul id="sb-'.$vv['id'].'" class="nav nav-stacked nav-pills collapse">';
                    foreach ($rs as $kkk => $vvv) {
                        if($vvv['is_blank'] == '1'){
                            $is_blank = 'target="_blank"';
                        }else{
                            $is_blank = '';
                        }
                        if ($now_menu_id == $vvv['id']) {

                            echo '<li role="presentation"><a href="'.$vvv['func_page'].'" '.$is_blank.'>'.$vvv['menu_name'].'</a></li>';
                            $now_menu['path'] = $vv['menu_name'].' > '.$vvv['menu_name'];
                        }else{
                            echo '<li role="presentation"><a href="'.$vvv['func_page'].'" '.$is_blank.'>'.$vvv['menu_name'].'</a></li>';    
                        }
                        
                    }
                    echo '</ul>';
                    echo '</li>';

                }else{
                    if($vv['is_blank'] == '1'){
                            $is_blank = 'target="_blank"';
                    }else{
                            $is_blank = '';
                    }
                    if($now_menu_id == $vv['id']){
                        echo '<li role="presentation"><a href="'.$vv['func_page'].'" '.$is_blank.'><span class="glyphicon glyphicon-'.$vv['icon'].'"></span> '.$vv['menu_name'].'</a></li>';
                        // $now_menu['func_page'] = $vv['menu_name'];
                    }else{
                        echo '<li role="presentation"><a href="'.$vv['func_page'].'" '.$is_blank.'><span class="glyphicon glyphicon-'.$vv['icon'].'"></span> '.$vv['menu_name'].'</a></li>';
                    }
                }
            }
        }        
    }
    public static function ImageResize_Transparent($from_filename, $save_filename, $in_width = 400, $in_height = 300, $quality=100){
        // 透明背景只有 png 和 gif 支援
        $allow_format = array('png', 'gif');
        $sub_name = $t = '';

        // Get new dimensions
        $img_info = getimagesize($from_filename);
        $width    = $img_info['0'];
        $height   = $img_info['1'];
        $mime     = $img_info['mime'];

        list($t, $sub_name) = explode('/', $mime);
        if (!in_array($sub_name, $allow_format))
            return false;
        // 取得縮在此範圍內的比例
        $percent = self::getResizePercent($width, $height, $in_width, $in_height);
        $new_width  = $width * $percent;
        $new_height = $height * $percent;
        // Resample
        $image_new = imagecreatetruecolor($new_width, $new_height);

        // $function_name: set function name
        //   => imagecreatefrompng, imagecreatefromgif
        // $sub_name = png, gif
        switch($sub_name){
            case 'png':
                $image = imagecreatefrompng($from_filename);
                break;
            case 'gif':
                $image = imagecreatefromgif($from_filename);
                break;
        }

        // 透明背景
        // imagealphablending($image_new, false);
        imagesavealpha($image_new, true);
        $color = imagecolorallocatealpha($image_new, 0, 0, 0, 127);
        imagefill($image_new, 0, 0, $color);

        imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        imagepng($image_new, $save_filename);
        // $function_name = 'image' . $sub_name;
        // return $function_name($image_new, $save_function);
        // imagepng($image_new, $save_filename, $quality);
        // imagedestroy($image_new);
    }

    public static function ImageResize($from_filename, $save_filename='', $in_width=400, $in_height=300, $quality=100){
        $allow_format = array('jpeg', 'png', 'gif');
        $sub_name = $t = '';
        $img_info = getimagesize($from_filename);
        $width    = $img_info['0'];
        $height   = $img_info['1'];
        $imgtype  = $img_info['2'];
        $imgtag   = $img_info['3'];
        $bits     = $img_info['bits'];
        $channels = $img_info['channels'];
        $mime     = $img_info['mime'];

        list($t, $sub_name) = explode('/', $mime);
        if ($sub_name == 'jpg') {
            $sub_name = 'jpeg';
        }

        if (!in_array($sub_name, $allow_format)) {
            return false;
        }

        // 取得縮在此範圍內的比例
        $percent = self::getResizePercent($width, $height, $in_width, $in_height);
        $new_width  = $width * $percent;
        $new_height = $height * $percent;

        // Resample
        $image_new = imagecreatetruecolor($new_width, $new_height);

        // $function_name: set function name
        //   => imagecreatefromjpeg, imagecreatefrompng, imagecreatefromgif
        /*
        // $sub_name = jpeg, png, gif
        $function_name = 'imagecreatefrom'.$sub_name;
        $image = $function_name($filename); //$image = imagecreatefromjpeg($filename);
        */
        switch($sub_name){
            case 'jpeg':
                $image = imagecreatefromjpeg($from_filename);
                break;
            case 'png':
                $image = imagecreatefrompng($from_filename);
                break;
            case 'gif':
                $image = imagecreatefromgif($from_filename);
                break;
        }
       

        imagecopyresampled($image_new, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        //return imagejpeg($image_new, $save_filename, $quality);
        //header('Content-type: image/jpeg');
        imagejpeg($image_new, $save_filename, $quality);
        imagedestroy($image_new);
    }
    public static function getResizePercent($source_w, $source_h, $inside_w, $inside_h){
        if ($source_w < $inside_w && $source_h < $inside_h) {
            return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
        }

        $w_percent = $inside_w / $source_w;
        $h_percent = $inside_h / $source_h;

        return ($w_percent > $h_percent) ? $h_percent : $w_percent;
    }
    public static function get_client_ip() {
        global $_SERVER;
        if (isset($_SERVER['HTTP_VIA']) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                list($IP,$USE_DNS)=split(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
                $PROXY=$_SERVER['REMOTE_ADDR'];

        } else {
                $IP = $_SERVER['REMOTE_ADDR'];
        }
        return $IP;
    }
    public static function timthumb($source,$width,$height,$zc=0) {
        return 'webimages/timthumb.php?src=webimages/'.$source.'&h='.$height.'&w='.$width.'&zc='.$zc;
    }
    public static function random($amount) {
        $random=$amount;
        for ($i=1;$i<=$random;$i=$i+1){
            $c=rand(1,3);
            //在$c==1的情況下，設定$a亂數取值為97-122之間，並用chr()將數值轉變為對應英文，儲存在$b
            if($c==1){$a=rand(97,122);$b=chr($a);}
            //在$c==2的情況下，設定$a亂數取值為65-90之間，並用chr()將數值轉變為對應英文，儲存在$b
            if($c==2){$a=rand(65,90);$b=chr($a);}
            //在$c==3的情況下，設定$b亂數取值為0-9之間的數字
            if($c==3){$b=rand(0,9);}
            //使用$randoma連接$b
            $randoma=$randoma.$b;
        }
        return $randoma;
    }
    public static function randomnum($amount) {
        $random=$amount;
        for ($i=1;$i<=$random;$i=$i+1){
            $b=rand(0,9);
            $randoma=$randoma.$b;
        }
        return $randoma;
    }
    
    public static function cleartag($text) {
        $descclear = "/<(\/?)(script|i?frame|style|html|body|li|i|map|title|img|link|span|u|font|table|tr|b|marquee|td|strong|div|a|meta|\?|\%)([^>]*?)>/isU";
        $descclear = preg_replace($descclear,"",$text);
        return $text;
    }
    public static function check_shelf($onshelf,$offshelf)
    {
        if($onshelf==0 || $onshelf==''){//立即上架
            if($offshelf==0 || $offshelf==''){//沒有下架時間
                return 1;
            }else if($offshelf>time()){//下架時間未到
                return 1;
            }else if($offshelf<time()){//下架時間到
                return 0;
            }
        }else{
            if($onshelf>time()){//上架時間未到
                return 0;
            }else{
                if($offshelf==0 || $offshelf==''){//沒有下架時間
                    return 1;
                }else if($offshelf>time()){//下架時間未到
                    return 1;
                }else if($offshelf<time()){//下架時間到
                    return 0;
                }
            }
        }
    }  
    public static function ismobile(){
        $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
        $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
        $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
        $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";   
        $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
        $regex_match.=")/i";
        return preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
    }

    public static function checkID($sid) {
        $tbNum = array(1,2,1,2,1,2,4,1);
        if(strlen($sid)!=8 || !preg_match("/^[0-9\*]{8}/",$sid)) return false;
        $intSum = 0;
        for ($i = 0; $i < count($tbNum); $i++){
            $intMultiply=substr($sid,$i,1)*$tbNum[$i];
            $intAddition=(floor($intMultiply / 10) + ($intMultiply % 10));
            $intSum+=$intAddition;
        }
        if(($intSum % 10 == 0 ) || ($intSum%10==9 && substr($sid,6,1)==7)) return true;
    }

    public static function checkemail($email){
        if(preg_match("/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/", $email,$result)){
            return true;
        }else{
            return false; 
        }
    }
    public static function checktel($tel){
        if(preg_match("/^[0][1-9]{1,3}[0-9]{6,8}$/", $tel,$result)){
            return true;
        }else{
            return false; 
        }
    }
    public static function checkphone($phone){
        if(preg_match("/^09[0-9]{2}[0-9]{6}$/", $phone,$result)){
            return true;
        }else{
            return false; 
        }
    }
    public static function checkisnumber($isnumber){
        if(is_numeric($isnumber)) {
			return true;
        }else{
            return false; 
        }
    }
}
