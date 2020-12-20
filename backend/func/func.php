<?php

function backend_page_function($rs, $PHPSELF, $last_page, $arr)
{
    if (!empty($arr))
    {
        while (list($kk, $vv) = each($arr))
        {
            $tmp1 .= "$kk=$vv&";
        }
    }
    $tmp1 = substr($tmp1, 0, strlen($tmp1) - 1);
    if (strlen($tmp1) > 0)
        $tmp1 = '&' . $tmp1;
    $tmp2 = '【&nbsp;&nbsp;<a href="' . $PHPSELF . '?next_page=1' . $tmp1 . '">最前頁</a>&nbsp;|&nbsp;<a href="' . $PHPSELF . '?next_page=' . ($rs->AbsolutePage() - 1) . $tmp1 . '">上一頁</a>&nbsp;|&nbsp;&nbsp;<a href="' . $PHPSELF . '?next_page=' . ($rs->AbsolutePage() + 1) . $tmp1 . '">下一頁</a>|&nbsp;&nbsp;<a href="' . $PHPSELF . '?next_page=' . $last_page . $tmp1 . '">最後頁</a>&nbsp;】' . "( " . $rs->AbsolutePage() . " / $last_page )";
    return $tmp2;
}

function msg_box($msg)
{
    if ($msg != "")
    {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '<script language="javascript">alert("' . $msg . '");</script>';
    }
    return "";
}

function go_to($go)
{
    if ($go == 1 || $go == -1)
        echo '<script language="javascript">history.go(' . $go . ')</script>';
    elseif ($go == -2)
        echo '<script language="javascript">history.back()</script>';
    else
        echo '<script language="javascript">window.location="' . $go . '"</script>';
}

function p_go_to($go)
{
    if ($go == 1 || $go == -1)
        echo '<script language="javascript">history.go(' . $go . ')</script>';
    elseif ($go == -2)
        echo '<script language="javascript">history.back()</script>';
    else
        echo '<script language="javascript">parent.window.location="' . $go . '"</script>';
}

function get_client_ip()
{
    global $_SERVER;
    if (isset($_SERVER['HTTP_VIA']) && isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        list($IP, $USE_DNS) = split(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
        $PROXY = $_SERVER['REMOTE_ADDR'];
    }
    else
    {
        $IP = $_SERVER['REMOTE_ADDR'];
    }
    return $IP;
}

function GetSQLValueString($theValue)
{
    //$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    if (version_compare(PHP_VERSION, '5.3.0', '<'))
    {
        if (get_magic_quotes_gpc())
        {
            if ($theValue != '')
            {
                $theValue = stripslashes($theValue);
            }
        }
    }

    //$theValue = function_exists("mysql_real_escape_string") ?mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
    $theValue = mysql_real_escape_string($theValue);
    return $theValue;
}

/*
 * 生成MENU
 * $arr_menu menu array
 * $now_menu_id

 */

function Make_Menu($arr_menu)
{
    global $now_menu;
    $now_menu_id = $now_menu['id'];
    if (is_array($arr_menu))
    {
        foreach ($arr_menu as $kk => $vv)
        {
            //是否有SUB MENU
            if (is_array($vv['sub_menu']))
            {
                if (in_array($now_menu_id, $vv['sub_menu_id']))
                {
                    echo '<li class="dropdown open active">';
                }
                else
                {
                    echo '<li class="dropdown">';
                }
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $vv['menu_name'] . '<b class="caret"></b></a>';
                echo '<ul class="dropdown-menu open">';
                foreach ($vv['sub_menu'] as $kkk => $vvv)
                {
                    if ($vvv['is_blank'] == '1')
                    {
                        $is_blank = 'target="_blank"';
                    }
                    else
                    {
                        $is_blank = '';
                    }
                    if ($now_menu_id == $vvv['id'])
                    {

                        echo '<li class="active"><a href="' . $vvv['menu_path'] . '" ' . $is_blank . '>' . $vvv['menu_name'] . '</a></li>';
                        $now_menu['path'] = $vv['menu_name'] . ' > ' . $vvv['menu_name'];
                    }
                    else
                    {
                        echo '<li><a href="' . $vvv['menu_path'] . '" ' . $is_blank . '>' . $vvv['menu_name'] . '</a></li>';
                    }
                }
                echo '</ul>';
                echo '</li>';
            }
            else
            {
                if ($vv['is_blank'] == '1')
                {
                    $is_blank = 'target="_blank"';
                }
                else
                {
                    $is_blank = '';
                }
                if ($now_menu_id == $vv['id'])
                {
                    echo '<li class="active"><a href="' . $vv['menu_path'] . '" ' . $is_blank . '>' . $vv['menu_name'] . '</a></li>';
                    $now_menu['path'] = $vv['menu_name'];
                }
                else
                {
                    echo '<li><a href="' . $vv['menu_path'] . '" ' . $is_blank . '>' . $vv['menu_name'] . '</a></li>';
                }
            }
        }
    }
}

function Get_Menu_Data($filename)
{
    global $db;
    $menu_path = basename($filename);

    $strSQL = "select * from u_menu_detail where menu_path='{$menu_path}'";

    $rs = $db->Execute($strSQL);
    if ($rs->EOF)
    {
        return 0;
    }
    else
    {
        $now_menu['id'] = $rs->fields['id'];
        $now_menu['menu_name'] = $rs->fields['menu_name'];
        $now_menu['func_page'] = basename($filename, '.php');
        return $now_menu;
    }
}

function ImageResize($from_filename, $save_filename = '', $in_width = 400, $in_height = 300, $quality = 100)
{
    $allow_format = array('jpeg', 'png', 'gif');
    $sub_name = $t = '';

    // Get new dimensions
    $img_info = getimagesize($from_filename);
    $width = $img_info['0'];
    $height = $img_info['1'];
    $imgtype = $img_info['2'];
    $imgtag = $img_info['3'];
    $bits = $img_info['bits'];
    $channels = $img_info['channels'];
    $mime = $img_info['mime'];

    list($t, $sub_name) = split('/', $mime);
    if ($sub_name == 'jpg')
    {
        $sub_name = 'jpeg';
    }

    if (!in_array($sub_name, $allow_format))
    {
        return false;
    }

    // 取得縮在此範圍內的比例
    $percent = getResizePercent($width, $height, $in_width, $in_height);
    $new_width = $width * $percent;
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
    switch ($sub_name)
    {
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

/**
 * 抓取要縮圖的比例
 * $source_w : 來源圖片寬度
 * $source_h : 來源圖片高度
 * $inside_w : 縮圖預定寬度
 * $inside_h : 縮圖預定高度
 *
 * Test:
 *   $v = (getResizePercent(1024, 768, 400, 300));
 *   echo 1024 * $v . "\n";
 *   echo  768 * $v . "\n";
 */
function getResizePercent($source_w, $source_h, $inside_w, $inside_h)
{
    if ($source_w < $inside_w && $source_h < $inside_h)
    {
        return 1; // Percent = 1, 如果都比預計縮圖的小就不用縮
    }

    $w_percent = $inside_w / $source_w;
    $h_percent = $inside_h / $source_h;

    return ($w_percent > $h_percent) ? $h_percent : $w_percent;
}

function fore_page($curr_page, $last_page, $arg = '')
{
    if ($last_page <= 0)
    {
        return 0;
    }
    if (is_array($arg))
    {
        foreach ($arg as $kk => $vv)
        {
            $page_tmp .= "{$kk}={$vv}&";
        }
    }
    echo '<ul class="pagination pagination-sm">';
    if ($curr_page <= 1)
    {
        echo '<li class="disabled">
                    <a href="#" onclick="return false;">&laquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=1">&laquo;</a>
                  </li>';
    }
    for ($i = 1; $i <= $last_page; $i++)
    {
        if ($i == $curr_page)
        {
            echo '<li class="active">
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '">' . $i . '</a>
                  </li>';
        }
        else
        {
            echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '">' . $i . '</a>
                  </li>';
        }
    }
    if ($curr_page >= $last_page)
    {
        echo '<li class="disabled">
                    <a href="#"  onclick="return false;">&raquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $last_page . '">&raquo;</a>
                  </li>';
    }
    echo '</ul>';
}

function fore_page1($curr_page, $last_page, $arg = '', $class_id)
{
    if ($last_page <= 0)
    {
        return 0;
    }
    if (is_array($arg))
    {
        foreach ($arg as $kk => $vv)
        {
            $page_tmp .= "{$kk}={$vv}&";
        }
    }
    echo '<ul class="pagination pagination-sm">';
    if ($curr_page <= 1)
    {
        echo '<li class="disabled">
                    <a href="#" onclick="return false;">&laquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=1&class_id=' . $class_id . '">&laquo;</a>
                  </li>';
    }
    for ($i = 1; $i <= $last_page; $i++)
    {
        if ($i == $curr_page)
        {
            echo '<li class="active">
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&class_id=' . $class_id . '">' . $i . '</a>
                  </li>';
        }
        else
        {
            echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&class_id=' . $class_id . '">' . $i . '</a>
                  </li>';
        }
    }
    if ($curr_page >= $last_page)
    {
        echo '<li class="disabled">
                    <a href="#"  onclick="return false;">&raquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $last_page . '&class_id=' . $class_id . '">&raquo;</a>
                  </li>';
    }
    echo '</ul>';
}

function fore_page2($curr_page, $last_page, $arg = '', $unit)
{
    if ($last_page <= 0)
    {
        return 0;
    }
    if (is_array($arg))
    {
        foreach ($arg as $kk => $vv)
        {
            $page_tmp .= "{$kk}={$vv}&";
        }
    }
    echo '<ul class="pagination pagination-sm">';
    if ($curr_page <= 1)
    {
        echo '<li class="disabled">
                    <a href="#" onclick="return false;">&laquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=1&unit=' . $unit . '">&laquo;</a>
                  </li>';
    }
    for ($i = 1; $i <= $last_page; $i++)
    {
        if ($i == $curr_page)
        {
            echo '<li class="active">
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&unit=' . $unit . '">' . $i . '</a>
                  </li>';
        }
        else
        {
            echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&unit=' . $unit . '">' . $i . '</a>
                  </li>';
        }
    }
    if ($curr_page >= $last_page)
    {
        echo '<li class="disabled">
                    <a href="#"  onclick="return false;">&raquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $last_page . '&unit=' . $unit . '">&raquo;</a>
                  </li>';
    }
    echo '</ul>';
}

function fore_page4($curr_page, $last_page, $arg = '', $type)
{
    if ($last_page <= 0)
    {
        return 0;
    }
    if (is_array($arg))
    {
        foreach ($arg as $kk => $vv)
        {
            $page_tmp .= "{$kk}={$vv}&";
        }
    }
    echo '<ul class="pagination pagination-sm">';
    if ($curr_page <= 1)
    {
        echo '<li class="disabled">
                    <a href="#" onclick="return false;">&laquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=1&type=' . $type . '">&laquo;</a>
                  </li>';
    }
    for ($i = 1; $i <= $last_page; $i++)
    {
        if ($i == $curr_page)
        {
            echo '<li class="active">
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&type=' . $type . '">' . $i . '</a>
                  </li>';
        }
        else
        {
            echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&type=' . $type . '">' . $i . '</a>
                  </li>';
        }
    }
    if ($curr_page >= $last_page)
    {
        echo '<li class="disabled">
                    <a href="#"  onclick="return false;">&raquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $last_page . '&type=' . $type . '">&raquo;</a>
                  </li>';
    }
    echo '</ul>';
}

function fore_page5($curr_page, $last_page, $arg = '', $class_id, $type)
{
    if ($last_page <= 0)
    {
        return 0;
    }
    if (is_array($arg))
    {
        foreach ($arg as $kk => $vv)
        {
            $page_tmp .= "{$kk}={$vv}&";
        }
    }
    echo '<ul class="pagination pagination-sm">';
    if ($curr_page <= 1)
    {
        echo '<li class="disabled">
                    <a href="#" onclick="return false;">&laquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=1&class_id=' . $class_id . '&type=' . $type . '">&laquo;</a>
                  </li>';
    }
    for ($i = 1; $i <= $last_page; $i++)
    {
        if ($i == $curr_page)
        {
            echo '<li class="active">
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&class_id=' . $class_id . '&type=' . $type . '">' . $i . '</a>
                  </li>';
        }
        else
        {
            echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $i . '&class_id=' . $class_id . '&type=' . $type . '">' . $i . '</a>
                  </li>';
        }
    }
    if ($curr_page >= $last_page)
    {
        echo '<li class="disabled">
                    <a href="#"  onclick="return false;">&raquo;</a>
                  </li>';
    }
    else
    {
        echo '<li>
                    <a href="?' . $page_tmp . 'curr_page=' . $last_page . '&class_id=' . $class_id . '&type=' . $type . '">&raquo;</a>
                  </li>';
    }
    echo '</ul>';
}

function goo_gl_short_url($longUrl)
{
    $GoogleApiKey = 'AIzaSyD2znL9R0dGJRk4_YLaTKRQD-0BCiRda0s';
    $postData = array('longUrl' => $longUrl, 'key' => $GoogleApiKey);
    $jsonData = json_encode($postData);
    $curlObj = curl_init();
    curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    //As the API is on https, set the value for CURLOPT_SSL_VERIFYPEER to false. This will stop cURL from verifying the SSL certificate.
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($curlObj);
    $json = json_decode($response);
    curl_close($curlObj);
    return $json->id;
}

function register_todo($user_id, $user_account)
{
    global $db;
    $project_name = $user_account;
    $app_id = 'tw.com.rainmaker.' . $user_account;
    //make_user_basic_setting
    $strSQL = "insert into make_user_basic_setting(`user_id`, `project_name`, `app_name`, `app_id`, `sender_id`, `fb_id`, `versionCode`, `versionName`, `app_icon`, `app_icon_ios`, `pic_320x480`, `pic_640x960`, `pic_640x1136`, `pic_240x320`, `pic_480x800`, `pic_240x400`, `pic_400x800`)
	select '" . $user_id . "', '$project_name', `app_name`, '" . $app_id . "', '', `fb_id`, `versionCode`, `versionName`, `app_icon`, `app_icon_ios`, `pic_320x480`, `pic_640x960`, `pic_640x1136`, `pic_240x320`, `pic_480x800`, `pic_240x400`, `pic_400x800` from make_user_basic_setting where user_id='" . __DATA_USER_ID . "'";

    $db->Execute($strSQL);
    //echo $strSQL;
    //exit;
    //make_menu_custom
    $strSQL = "insert into make_menu_custom(`user_id`, `menu_detail_id`, `menu_name`, `sort`, `isable`)
	select '" . $user_id . "', `menu_detail_id`, `menu_name`, `sort`, `isable` from make_menu_custom where user_id='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);
    //make_app_settings
    $strSQL = "insert into make_app_settings(`user_id`, `__MENU_STYLE`, `__WINDOW_BACKGROUND_COLOR`, `__HEADER_BACKGROUND_COLOR`, `__HEADER_LOGO_IMG`, `__HEADER_BACK_IMG`, `__HEADER_FONT_COLOR`, `__FOOTER_BACKGROUND_COLOR`, `__TAB_PAGE_BACKGROUND_COLOR`, `__TAB_PAGE_UNDERLINE_COLOR`, `__TAB_PAGE_FONT_COLOR`, `__ROW_BACKGROUND_COLOR`, `__ROW_BORDER_COLOR`, `__ROW_CONTENT_BACKGROUND_COLOR`, `__ROW_FONT_COLOR`, `__ROW_ICON_IMG`, `__NEWS_ROW_BACKGROUND_COLOR`, `__NEWS_ROW_BORDER_COLOR`, `__INDEX_TOP_IMAGE`, `top_align`, `__INDEX_BOTTOM_IMAGE`, `bottom_align`, `__DETAIL_FLOWER_IMAGE`, `flower_align`, `__DETAIL_LOGO_IMAGE`) 
	select '" . $user_id . "', `__MENU_STYLE`, `__WINDOW_BACKGROUND_COLOR`, `__HEADER_BACKGROUND_COLOR`, `__HEADER_LOGO_IMG`, `__HEADER_BACK_IMG`, `__HEADER_FONT_COLOR`, `__FOOTER_BACKGROUND_COLOR`, `__TAB_PAGE_BACKGROUND_COLOR`, `__TAB_PAGE_UNDERLINE_COLOR`, `__TAB_PAGE_FONT_COLOR`, `__ROW_BACKGROUND_COLOR`, `__ROW_BORDER_COLOR`, `__ROW_CONTENT_BACKGROUND_COLOR`, `__ROW_FONT_COLOR`, `__ROW_ICON_IMG`, `__NEWS_ROW_BACKGROUND_COLOR`, `__NEWS_ROW_BORDER_COLOR`, `__INDEX_TOP_IMAGE`, `top_align`, `__INDEX_BOTTOM_IMAGE`, `bottom_align`, `__DETAIL_FLOWER_IMAGE`, `flower_align`, `__DETAIL_LOGO_IMAGE` from make_app_settings where user_id='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);
    //good_tours
    $strSQL = "insert into good_tours(`user_id`, `title`, `content`, `sort`)
	select '" . $user_id . "', `title`, `content`, `sort` from good_tours where user_id='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);
    //medals
    $strSQL = "insert into medals(`user_id`, `title`, `img`, `qr_img`)
	select '" . $user_id . "',  `title`, `img`, `qr_img` from medals where user_id='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);

    //news
    $strSQL = "insert into news(`user_id`, `title`, `content`, `img`)
	select '" . $user_id . "',  `title`, `content`, `img` from news where user_id='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);

    //qr_code_guide
    $strSQL = "insert into qr_code_guide(`user_id`, `title`, `content`, `s_img_path`, `m_img_path`, `l_img_path`)
	select '" . $user_id . "', `title`, `content`, `s_img_path`, `m_img_path`, `l_img_path` from qr_code_guide where user_id='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);

    //service
    $strSQL = "insert into service(`user_id`, `title`, `content`, `sort`)
	select '" . $user_id . "', `title`, `content`, `sort` from service where user_id='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);
    //virtual
    //u_material
    /*
      $strSQL = "insert into u_material(`user_id`, `title`, `material_type_id`, `modify_time`)
      select '".$user_id."', `title`, `material_type_id`, `modify_time` from u_material where user_id='".__DATA_USER_ID."'";
      $db->Execute($strSQL);
     */
    $strSQL = "select * from u_material where `user_id`='" . __DATA_USER_ID . "'";
    $rs = $db->Execute($strSQL);
    /*
      define('__M_PICTURE_ID',1);
      define('__M_VIDEO_ID',2);
      define('__M_PANORAMA_ID',3);
      define('__M_OBJECT_ID',4);
     */
    while (!$rs->EOF)
    {
        $title = $rs->fields['title'];
        $material_type_id = $rs->fields['material_type_id'];
        $o_u_material_id = $rs->fields['id'];
        $strSQL = "insert into u_material(user_id,title,material_type_id) values('$user_id','$title','$material_type_id')";
        $db->Execute($strSQL);
        $u_material_id = $db->Insert_ID();
        $material_mapping[$o_u_material_id] = $u_material_id;

        switch ($material_type_id)
        {
            case __M_PICTURE_ID:
                $strSQL = "insert into u_material_picture(`u_material_id`,  `user_id`, `filename`, `tmp_name`)
				select '" . $u_material_id . "', '" . $user_id . "', `filename`, `tmp_name` from u_material_picture where u_material_id='" . $o_u_material_id . "'";
                $db->Execute($strSQL);
                break;
            case __M_VIDEO_ID:
                $strSQL = "insert into u_material_youtube(`u_material_id`, `user_id`, `url`)
				select '" . $u_material_id . "', '" . $user_id . "', `url` from u_material_youtube where u_material_id='" . $o_u_material_id . "'";
                $db->Execute($strSQL);
                break;
            case __M_PANORAMA_ID:
                $strSQL = "insert into u_material_vrtcc(`u_material_id`, `user_id`, `flash_url`, `html5_url`, `html5_tar`, `is_upload`, `is_done`, `status`, `send_response`)
				select '" . $u_material_id . "', '" . $user_id . "' , `flash_url`, `html5_url`, `html5_tar`, `is_upload`, `is_done`, `status`, `send_response` from u_material_vrtcc where u_material_id='" . $o_u_material_id . "'";

                $db->Execute($strSQL);
                break;
            case __M_OBJECT_ID:
                $strSQL = "insert into u_material_object(`u_material_id`, `user_id`, `sn`, `tmp_name`)
				select '" . $u_material_id . "', '" . $user_id . "', `sn`, `tmp_name` from u_material_object where u_material_id='" . $o_u_material_id . "'";
                $db->Execute($strSQL);
                break;
        }


        $rs->MoveNext();
    }

    //u_public_scenic
    $strSQL = "select * from u_public_scenic where `user_id`='" . __DATA_USER_ID . "'";
    $rs = $db->Execute($strSQL);
    while (!$rs->EOF)
    {
        $o_u_public_scenic_id = $rs->fields['id'];
        $title = $rs->fields['title'];
        $isable = $rs->fields['isable'];
        $sort = $rs->fields['sort'];

        $strSQL = "insert into u_public_scenic(user_id,title,isable,sort) values('$user_id','$title','$isable','$sort')";
        $db->Execute($strSQL);
        $u_public_scenic_id = $db->Insert_ID();
        $strSQL = "select * from u_public_scenic__material where u_public_scenic_id='" . $o_u_public_scenic_id . "'";
        $rs1 = $db->Execute($strSQL);
        while (!$rs1->EOF)
        {
            $u_material_id = $material_mapping[$rs1->fields['u_material_id']];
            $material_name = $rs1->fields['material_name'];
            $memo = $rs1->fields['memo'];
            $sort = $rs1->fields['sort'];
            $strSQL = "insert into u_public_scenic__material(`user_id`, `u_public_scenic_id`, `u_material_id`, `material_name`, `memo`, `sort`) values('$user_id','$u_public_scenic_id','$u_material_id','$material_name','$memo','$sort');";
            $db->Execute($strSQL);
            $rs1->MoveNext();
        }
        $rs->MoveNext();
    }
    //u_ques
    $strSQL = "insert into u_ques_list(`ql_uid`, `ql_title`, `ql_cont`, `ql_online`, `ql_date`)
	select '" . $user_id . "', `ql_title`, `ql_cont`, `ql_online`, `ql_date` from u_ques_list where ql_uid='" . __DATA_USER_ID . "'";
    $db->Execute($strSQL);
    $strSQL = "select * from u_ques_list where ql_uid='" . __DATA_USER_ID . "'";
    $rs = $db->Execute($strSQL);
    $o_ql_id = $rs->fields['ql_id'];

    $strSQL = "select * from u_ques_list where ql_uid='" . $user_id . "'";
    $rs = $db->Execute($strSQL);
    $ql_id = $rs->fields['ql_id'];

    $strSQL = "select * from u_ques_ques where ql_id='$o_ql_id'";
    $rs = $db->Execute($strSQL);
    while (!$rs->EOF)
    {
        $o_qq_id = $rs->fields['qq_id'];
        $qq_analysis = trim($rs->fields['qq_analysis']);
        $qq_num = trim($rs->fields['qq_num']);
        $qq_ques = trim($rs->fields['qq_ques']);
        $qq_type = trim($rs->fields['qq_type']);
        $qq_other = trim($rs->fields['qq_other']);
        $strSQL = "insert into u_ques_ques(`ql_id`, `qq_analysis`, `qq_num`, `qq_ques`, `qq_type`, `qq_other`) values('$ql_id','$qq_analysis','$qq_num','$qq_ques','$qq_type','$qq_other');";
        $db->Execute($strSQL);
        $qq_id = $db->Insert_ID();
        if ($qq_type == 'radio')
        {
            $strSQL = "insert into u_ques_option(`ql_id`, `qq_id`, `qo_title`, `qo_other`, `qo_order`) select '$ql_id','$qq_id',qo_title,qo_other,qo_order from u_ques_option where qq_id='$qq_id' and ql_id='$o_ql_id'";
            $db->Execute($strSQL);
        }
        $rs->MoveNext();
    }
}

function get_age_id($birthday)
{
    global $db;
    $age = floor((mktime() - $birthday) / 365.25 / 86400);
    switch (true)
    {
        case($age <= 20):
            return 1;
            break;
        case($age > 20 && $age <= 25):
            return 2;
            break;
        case($age > 25 && $age <= 30):
            return 3;
            break;
        case($age > 30 && $age <= 35):
            return 4;
            break;
        case($age > 35 && $age <= 40):
            return 5;
            break;
        case($age > 40 && $age <= 45):
            return 6;
            break;
        case($age > 45 && $age <= 50):
            return 7;
            break;
        default:
            return 8;
    }
}

function MboxiiAPI($func, $form)
{
    switch ($func)
    {
        case 1://add
            //http://簡訊網站網址/api/api_personal.php?func=add
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //有沒有顯示
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_REFERER, 'http://' . __MBOX_DOMAIN . '/api/api_personal.php?func=add');
            $f['admin_id'] = __MBOX_ACCOUNT;
            $f['admin_pwd'] = __MBOX_PASS;
            $f['p[p_id]'] = $form['p_id'];
            $f['p[p_pwd]'] = $form['p_pwd'];
            $f['p[p_name]'] = $form['p_name'];
            $f['p[p_sex]'] = 'm';

            $f['p[company_name]'] = $form['company_name'];
            $f['p[p_status]'] = 1;
            curl_setopt($ch, CURLOPT_URL, "http://" . __MBOX_DOMAIN . "/api/api_personal.php?func=add");
            curl_setopt($ch, CURLOPT_POSTFIELDS, FormValueEncode($f));
            $Result = curl_exec($ch);
            curl_close($ch);
            //echo FormValueEncode($f);
            //echo $Result;
            //exit;
            return $Result;
            break;
        case 2://update
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //有沒有顯示
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_REFERER, 'http://' . __MBOX_DOMAIN . '/api/api_personal.php?func=update');
            $f['admin_id'] = __MBOX_ACCOUNT;
            $f['admin_pwd'] = __MBOX_PASS;
            $f['p[p_pwd]'] = $form['p_pwd'];
            $f['p[p_name]'] = $form['p_name'];
            $f['p[p_sex]'] = 'm';
            $f['p[p_id]'] = $form['p_id'];

            $f['p[company_name]'] = $form['company_name'];
            $f['p[p_status]'] = 1;
            curl_setopt($ch, CURLOPT_URL, "http://" . __MBOX_DOMAIN . "/api/api_personal.php?func=update");
            curl_setopt($ch, CURLOPT_POSTFIELDS, FormValueEncode($f));
            $Result = curl_exec($ch);
            curl_close($ch);
            return $Result;
            break;
        case '3':
            break;
    }
}

?>