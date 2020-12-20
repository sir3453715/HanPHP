<?php
//phpinfo();
//exit;

$member_id = Session::get('member_id',SESSION_BACKEND);


switch ($_GET['func']):
    case "update":
        $news_id = $_GET['id'];
        $strSQL = "SELECT * FROM news WHERE id = '$news_id'";        
        $arr_data = $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $img = $arr_data[0]['img'];
        $con_img = $arr_data[0]['con_img'];
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $create_date=strtotime($create_date,'00:00:00');
            $update_date = time();
            if($_FILES['img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                @unlink(__SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                $img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 180, 181);
                }else{
                    Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 180, 181);
                }
            }
            if ($del_img == 'true')
            {
                $img = '';
            } 
            if($_FILES['con_img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['con_img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                @unlink(__SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $con_img);
                $con_img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['con_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $con_img, 502, 503);
                }else{
                    Func::ImageResize($_FILES['con_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $con_img, 502, 503);
                }
            }
            if ($del_con_img == 'true')
            {
                $con_img = '';
            }
            $data = array(
                'create_date'=>$create_date,
                'update_date'=>$update_date,
                'title'=>$title,
                'overview'=>$overview,
                'content'=>$content,
                'status'=>$status,
                'isindex'=>$isindex,
                'img'=>$img,
                'con_img'=>$con_img,
            );
            $a = $db->update('news',$data,"id = '$news_id'");
            if(!$a){
                FuncSite::msg_box('更新成功！');
            }else{
                FuncSite::msg_box_error('更新失敗！');
            }     
            Func::go_to($func_page . '.php');
            exit;
        }
        $data = array();
        array_push($data, array(
            'title' => '首頁顯示',
            'type' => 'radio',
            'name' => 'isindex',
            'value' => 1,
            'options'=>$arr_isindex
                )
        );
        array_push($data, array(
            'title' => '啟用設定',
            'type' => 'radio',
            'name' => 'status',
            'value' => $arr_data[0]['status'],
            'options'=>$arr_ison
                )
        );
        array_push($data, array(
            'title' => '發佈日期',
            'type' => 'date',
            'name' => 'create_date',
            'value' => date('Y-m-d',$arr_data[0]['create_date']),
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '內容設定',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
            'title' => '標題',
            'type' => 'text',
            'name' => 'title',
            'value' => $arr_data[0]['title'],
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
                'title' => '圖片',
                'type' => 'image',
                'name' => 'img',
                'value' => $arr_data[0]['img'],
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 180 * 181 ，或等比例之圖片。其檔案大小不得超過2M',
                'delete' => true
            )
        );
        array_push($data, array(
                'title' => '內文圖片',
                'type' => 'image',
                'name' => 'con_img',
                'value' => $arr_data[0]['con_img'],
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 502 * 503 ，或等比例之圖片。其檔案大小不得超過2M',
                'delete' => true
            )
        );
        array_push($data, array(
            'title' => '內文概述',
            'type' => 'textarea',
            'name' => 'overview',
            'cols' => "50",
            'rows' => "5",
            'value' => $arr_data[0]['overview'],
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '內文',
            'type' => 'html',
            'name' => 'content',
            "required" => true,
            'height' => 500,
            'value' => $arr_data[0]['content']
            )
        );
        $arr_form1 = array(
            "func" => 'update',
            "form_title" => '基本設定',
            "form_name" => 'form1',
            "elements" => $data
        );
        $arr_date  = array(
            "create_date" => $arr_data[0]['create_date'],
            "update_date" => $arr_data[0]['update_date']
        );    
        break;
    case "delete":
        $news_id = $_GET['id'];
        $strSQL = "SELECT * FROM news WHERE id = '$news_id'";
        $db->Execute($strSQL);
        if($db->Affected_Rows()<1){
            FuncSite::msg_box_error('查無資料！');
            Func::go_to(-1);
            exit;
        }
        $db->delete('news',"id='$news_id'");
        Func::go_to($func_page . '.php?');
        exit;
        break;

    case "insert":
        if($_POST['flag'] == 'true'){
            foreach ($_POST as $kk => $vv)
            {
                $$kk = (trim($vv));
            }
            $create_date=strtotime($create_date,'00:00:00');
            $update_date = time();
            
            if($_FILES['img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                $img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 180, 181);
                }else{
                    Func::ImageResize($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img, 180, 181);
                }
            }

            if($_FILES['con_img']['tmp_name']){
                $ext = strtolower(pathinfo($_FILES['con_img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, $array_img_ext) === false){
                    FuncSite::msg_box_error('圖片格式錯誤！');
                    Func::go_to(-1);                            
                    exit;
                }
                $con_img = time().rand(100,999) . '.' . $ext;
                // $a = copy($_FILES['img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $img);
                if($ext=='png' || $ext=='gif'){
                    Func::ImageResize_Transparent($_FILES['con_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $con_img, 502, 503);
                }else{
                    Func::ImageResize($_FILES['con_img']['tmp_name'], __SERVER_IMAGES_FOLDER . DIRECTORY_SEPARATOR . $con_img, 502, 503);
                }
            }
            $data = array(
                'create_date'=>$create_date,
                'title'=>$title,
                'overview'=>$overview,
                'content'=>$content,
                'status'=>$status,
                'isindex'=>$isindex,
                'update_date'=>$update_date,
                'img'=>$img,
                'con_img'=>$con_img,
            );
            // print_r($data);
            // exit;
            $a = $db->insert('news',$data);
            if($a){
                FuncSite::msg_box('新增成功！');
            }else{
                FuncSite::msg_box_error('新增失敗！');
            }            
            Func::go_to($func_page . '.php?');
            exit;
        }
        $data = array();
        array_push($data, array(
            'title' => '首頁顯示',
            'type' => 'radio',
            'name' => 'isindex',
            'value' => 1,
            'options'=>$arr_isindex
                )
        );
        array_push($data, array(
            'title' => '啟用設定',
            'type' => 'radio',
            'name' => 'status',
            'value' => '1',
            'options'=>$arr_ison
                )
        );        
        array_push($data, array(
            'title' => '內容設定',
            'type' => 'more_title'
            )
        );
        array_push($data, array(
            'title' => '發佈日期',
            'type' => 'date',
            'name' => 'create_date',
            'value' => date('Y-m-d'),
            "required" => true
                )
        );
        array_push($data, array(
            'title' => '標題',
            'type' => 'text',
            'name' => 'title',
            'length' => 30,
            'max_length' => 50,
            "required" => true
                )
        );
        array_push($data, array(
                'title' => '圖片',
                'type' => 'image',
                'name' => 'img',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 180 * 181 ，或等比例之圖片。其檔案大小不得超過2M',
                // 'max_size' => 4096,
                'delete' => true
            )
        );
        array_push($data, array(
                'title' => '內文圖片',
                'type' => 'image',
                'name' => 'con_img',
                'pre_folder' => __WEB_IMAGES_FOLDER,
                'help' => '建議寬高: 502 * 503 ，或等比例之圖片。其檔案大小不得超過2M',
                'delete' => true
            )
        );
        array_push($data, array(
            'title' => '內文概述',
            'type' => 'textarea',
            'name' => 'overview',
            'cols' => "50",
            'rows' => "5",
            "required" => true
                )
        );  
        array_push($data, array(
            'title' => '內文',
            'type' => 'html',
            'name' => 'content',
            'height' => 500,
            "required" => true
            )
        );
        $arr_form1 = array(
            "func" => 'insert',
            "form_name" => 'form1',
            "form_title" => '基本設定',
            "elements" => $data
        ); 
        break;
    default:
        $arr_data = array();
        $andSQL = '';
        $status = $_GET['status'];
        $keyword = $_GET['keyword'];
        if($status!='' and $status<>3){
            $andSQL .= "and status=".$status;
        }elseif($keyword!=''){
            $andSQL .= "and title like '%".$keyword."%'";
        }
        $strSQL = "SELECT * FROM news WHERE 1 $andSQL ORDER BY create_date desc";
        // echo $strSQL;
        // exit;
        $rs = $db->Execute($strSQL);
        $rows = $db->Affected_Rows();
        $curr_page = $_GET['curr_page'];
        $last_page = ceil($rows / __DATA_PER_PAGE);
        if ($curr_page > $last_page)
            $curr_page = $last_page;
        if ($curr_page < 1)
            $curr_page = 1;
        if ($last_page == 0)
            $curr_page = 0;
        $arr_data = $db->PageExecute($strSQL, __DATA_PER_PAGE, $curr_page);
endswitch;
?>